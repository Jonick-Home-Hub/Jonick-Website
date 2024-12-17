<?php

class Payments extends DatabaseObject
{
    // Table name
    static protected $table_name = "payments";

    // Database columns
    static protected $db_columns = ['id', 'booking_id', 'payment_method', 'transaction_id', 'amount', 'status', 'created_at', 'updated_at'];

    // Class properties for each column
    public $id;
    public $booking_id; // Foreign key to bookings table
    public $payment_method; // 'card', 'bank_transfer', etc.
    public $transaction_id; // Unique transaction reference
    public $amount; // Payment amount
    public $status; // 'pending', 'completed', 'failed', etc.
    public $created_at;
    public $updated_at;

    // Constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->booking_id = $args['booking_id'] ?? null;
        $this->payment_method = $args['payment_method'] ?? 'card';
        $this->transaction_id = $args['transaction_id'] ?? '';
        $this->amount = $args['amount'] ?? 0.00;
        $this->status = $args['status'] ?? 'pending';
        $this->created_at = $args['created_at'] ?? null;
        $this->updated_at = $args['updated_at'] ?? null;
    }

    // Create a payment record
    static public function createPayment($data)
    {
        $payment = new self($data);

        $errors = $payment->validate();
        if (!empty($errors)) {
            return ['status' => 'error', 'message' => 'Validation failed', 'errors' => $errors];
        }

        $save_query = $payment->save();

        return $save_query
            ? ['status' => 'success', 'message' => 'Payment created successfully']
            : ['status' => 'error', 'message' => 'Payment creation failed'];
    }

    // Retrieve all payments
    static public function allPayments()
    {
        return self::findAll();
    }

    // Retrieve payments by booking
    static public function findPaymentsByBooking($booking_id)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE booking_id = :booking_id";
        $stmt = self::executeQuery($sql, ['booking_id' => $booking_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve payment by transaction ID
    static public function findPaymentByTransactionId($transaction_id)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE transaction_id = :transaction_id";
        $stmt = self::executeQuery($sql, ['transaction_id' => $transaction_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? static::instantiate($result) : null;
    }

    // Update payment status
    static public function updateStatus($id, $status)
    {
        $payment = self::findById($id);

        if (!$payment) {
            return ['status' => 'error', 'message' => 'Payment not found'];
        }

        $payment->status = $status;
        $update_query = $payment->save();

        return $update_query
            ? ['status' => 'success', 'message' => 'Payment status updated successfully']
            : ['status' => 'error', 'message' => 'Payment status update failed'];
    }

    // Validation for payment fields
    protected function validate()
    {
        $this->errors = [];

        if (empty($this->booking_id)) {
            $this->errors[] = "Booking ID is required.";
        }

        if (empty($this->payment_method)) {
            $this->errors[] = "Payment method is required.";
        }

        if (empty($this->transaction_id)) {
            $this->errors[] = "Transaction ID is required.";
        }

        if (!is_numeric($this->amount) || $this->amount <= 0) {
            $this->errors[] = "Amount must be a positive number.";
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
