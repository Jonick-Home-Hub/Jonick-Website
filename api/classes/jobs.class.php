<?php

class Jobs extends DatabaseObject
{
    // Table name
    static protected $table_name = "jobs";

    // Database columns
    static protected $db_columns = ['id', 'service_id', 'user_id', 'professional_id', 'status', 'description', 'scheduled_date', 'created_at', 'updated_at'];

    // Class properties for each column
    public $id;
    public $service_id;         // Foreign key to services table
    public $user_id;            // Foreign key to users table (buyer who booked the job)
    public $professional_id;    // Foreign key to professionals table (pro assigned to the job)
    public $status;             // 'pending', 'in_progress', 'completed', 'canceled'
    public $description;        // Additional details about the job
    public $scheduled_date;     // Scheduled date and time for the job
    public $created_at;
    public $updated_at;

    // Constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->service_id = $args['service_id'] ?? null;
        $this->user_id = $args['user_id'] ?? null;
        $this->professional_id = $args['professional_id'] ?? null;
        $this->status = $args['status'] ?? 'pending';
        $this->description = $args['description'] ?? '';
        $this->scheduled_date = $args['scheduled_date'] ?? null;
        $this->created_at = $args['created_at'] ?? null;
        $this->updated_at = $args['updated_at'] ?? null;
    }

    // Create a job
    static public function createJob($data)
    {
        $job = new self($data);

        $errors = $job->validate();
        if (!empty($errors)) {
            return ['status' => 'error', 'message' => 'Validation failed', 'errors' => $errors];
        }

        $save_query = $job->save();

        return $save_query
            ? ['status' => 'success', 'message' => 'Job created successfully']
            : ['status' => 'error', 'message' => 'Job creation failed'];
    }

    // Retrieve all jobs
    static public function allJobs()
    {
        return self::findAll();
    }

    // Retrieve jobs by status
    static public function findJobsByStatus($status)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE status = :status";
        $stmt = self::executeQuery($sql, ['status' => $status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve jobs by professional
    static public function findJobsByProfessional($professional_id)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE professional_id = :professional_id";
        $stmt = self::executeQuery($sql, ['professional_id' => $professional_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve jobs by user
    static public function findJobsByUser($user_id)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE user_id = :user_id";
        $stmt = self::executeQuery($sql, ['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update job status
    static public function updateStatus($id, $status)
    {
        $job = self::findById($id);

        if (!$job) {
            return ['status' => 'error', 'message' => 'Job not found'];
        }

        $job->status = $status;
        $update_query = $job->save();

        return $update_query
            ? ['status' => 'success', 'message' => 'Job status updated successfully']
            : ['status' => 'error', 'message' => 'Job status update failed'];
    }

    // Validation for job fields
    protected function validate()
    {
        $this->errors = [];

        if (empty($this->service_id)) {
            $this->errors[] = "Service ID is required.";
        }

        if (empty($this->user_id)) {
            $this->errors[] = "User ID is required.";
        }

        if (empty($this->scheduled_date)) {
            $this->errors[] = "Scheduled date is required.";
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
