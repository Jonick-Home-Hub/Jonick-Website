<?php

class Bookings extends DatabaseObject
{
    // Table name
    static protected $table_name = "bookings";

    // Database columns
    static protected $db_columns = ['id', 'user_id', 'service_id', 'professional_id', 'status', 'appointment_date', 'total_price', 'created_at', 'updated_at'];

    // Class properties for each column
    public $id;
    public $user_id; // Foreign key to users table
    public $service_id; // Foreign key to services table
    public $professional_id; // Foreign key to professionals table
    public $status; // 'pending', 'confirmed', 'completed', 'cancelled'
    public $appointment_date;
    public $total_price;
    public $created_at;
    public $updated_at;

    // Constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->user_id = $args['user_id'] ?? null;
        $this->service_id = $args['service_id'] ?? null;
        $this->professional_id = $args['professional_id'] ?? null;
        $this->status = $args['status'] ?? 'pending';
        $this->appointment_date = $args['appointment_date'] ?? null;
        $this->total_price = $args['total_price'] ?? 0.00;
        $this->created_at = $args['created_at'] ?? null;
        $this->updated_at = $args['updated_at'] ?? null;
    }

    // Create a booking
    static public function createBooking($data)
    {
        $booking = new self($data);

        $errors = $booking->validate();
        if (!empty($errors)) {
            return ['status' => 'error', 'message' => 'Validation failed', 'errors' => $errors];
        }

        $save_query = $booking->save();

        return $save_query
            ? ['status' => 'success', 'message' => 'Booking created successfully']
            : ['status' => 'error', 'message' => 'Booking creation failed'];
    }

    // Update booking status
    static public function updateStatus($id, $status)
    {
        $booking = self::findById($id);

        if (!$booking) {
            return ['status' => 'error', 'message' => 'Booking not found'];
        }

        $booking->status = $status;
        $update_query = $booking->save();

        return $update_query
            ? ['status' => 'success', 'message' => 'Booking status updated successfully']
            : ['status' => 'error', 'message' => 'Booking status update failed'];
    }

    // Retrieve all bookings
    static public function allBookings()
    {
        return self::findAll();
    }

    // Retrieve bookings by user
    static public function findBookingsByUser($user_id)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE user_id = :user_id";
        $stmt = self::executeQuery($sql, ['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve bookings by professional
    static public function findBookingsByProfessional($professional_id)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE professional_id = :professional_id";
        $stmt = self::executeQuery($sql, ['professional_id' => $professional_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve booking by ID
    static public function findBookingById($id)
    {
        return self::findById($id);
    }

    // Validation for booking fields
    protected function validate()
    {
        $this->errors = [];

        if (empty($this->user_id)) {
            $this->errors[] = "User ID is required.";
        }

        if (empty($this->service_id)) {
            $this->errors[] = "Service ID is required.";
        }

        if (empty($this->appointment_date)) {
            $this->errors[] = "Appointment date is required.";
        }

        if (!is_numeric($this->total_price) || $this->total_price < 0) {
            $this->errors[] = "Total price must be a positive number.";
        }

        return $this->errors;
    }

    // Helper functions
    private function is_blank($value)
    {
        return !isset($value) || trim($value) === '';
    }
}

?>
