<?php

class Professionals extends DatabaseObject
{
    // Table name
    static protected $table_name = "professionals";

    // Database columns
    static protected $db_columns = ['id', 'user_id', 'expertise', 'availability', 'status', 'created_at'];

    // Class properties for each column
    public $id;
    public $user_id;
    public $expertise;
    public $availability; // e.g., JSON or serialized data
    public $status; // 'pending', 'approved', or 'rejected'
    public $created_at;

    // Constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->user_id = $args['user_id'] ?? null;
        $this->expertise = $args['expertise'] ?? '';
        $this->availability = $args['availability'] ?? ''; // Default empty or specify format
        $this->status = $args['status'] ?? 'pending'; // Default status is 'pending'
        $this->created_at = $args['created_at'] ?? null;
    }

    // Apply to become a professional
    static public function apply($data)
    {
        $professional = new self($data);

        $errors = $professional->validate();
        if (!empty($errors)) {
            return ['status' => 'error', 'message' => 'Validation failed', 'errors' => $errors];
        }

        $save_query = $professional->save();

        return $save_query
            ? ['status' => 'success', 'message' => 'Application submitted successfully']
            : ['status' => 'error', 'message' => 'Application submission failed'];
    }

    // Approve a professional
    static public function approve($id)
    {
        $professional = self::findById($id);

        if (!$professional) {
            return ['status' => 'error', 'message' => 'Professional not found'];
        }

        $professional->status = 'approved';
        $update_query = $professional->save();

        return $update_query
            ? ['status' => 'success', 'message' => 'Professional approved successfully']
            : ['status' => 'error', 'message' => 'Approval failed'];
    }

    // Reject a professional
    static public function reject($id)
    {
        $professional = self::findById($id);

        if (!$professional) {
            return ['status' => 'error', 'message' => 'Professional not found'];
        }

        $professional->status = 'rejected';
        $update_query = $professional->save();

        return $update_query
            ? ['status' => 'success', 'message' => 'Professional rejected successfully']
            : ['status' => 'error', 'message' => 'Rejection failed'];
    }

    // Retrieve all professionals
    static public function allProfessionals()
    {
        return self::findAll();
    }

    // Retrieve professional by ID
    static public function findProfessionalById($id)
    {
        return self::findById($id);
    }

    // Retrieve professionals by status
    static public function findProfessionalsByStatus($status)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE status = :status";
        $stmt = self::executeQuery($sql, ['status' => $status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Validation for professional fields
    protected function validate()
    {
        $this->errors = [];

        if (empty($this->user_id)) {
            $this->errors[] = "User ID is required.";
        }

        if ($this->is_blank($this->expertise)) {
            $this->errors[] = "Expertise cannot be blank.";
        }

        if (!in_array($this->status, ['pending', 'approved', 'rejected'])) {
            $this->errors[] = "Invalid status value.";
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
