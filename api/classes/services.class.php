<?php

class Services extends DatabaseObject
{
    // Table name
    static protected $table_name = "services";

    // Database columns
    static protected $db_columns = ['id', 'name', 'description', 'price', 'category_id', 'created_at', 'updated_at'];

    // Class properties for each column
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id; // Foreign key to categories table
    public $created_at;
    public $updated_at;

    // Constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->price = $args['price'] ?? 0.00;
        $this->category_id = $args['category_id'] ?? null;
        $this->created_at = $args['created_at'] ?? null;
        $this->updated_at = $args['updated_at'] ?? null;
    }

    // Create a new service
    static public function createService($data)
    {
        $service = new self($data);

        $errors = $service->validate();
        if (!empty($errors)) {
            return ['status' => 'error', 'message' => 'Validation failed', 'errors' => $errors];
        }

        $save_query = $service->save();

        return $save_query
            ? ['status' => 'success', 'message' => 'Service created successfully']
            : ['status' => 'error', 'message' => 'Service creation failed'];
    }

    // Update an existing service
    static public function updateService($id, $data)
    {
        $service = self::findById($id);

        if (!$service) {
            return ['status' => 'error', 'message' => 'Service not found'];
        }

        $service->mergeAttributes($data);
        $errors = $service->validate();

        if (!empty($errors)) {
            return ['status' => 'error', 'message' => 'Validation failed', 'errors' => $errors];
        }

        $update_query = $service->save();

        return $update_query
            ? ['status' => 'success', 'message' => 'Service updated successfully']
            : ['status' => 'error', 'message' => 'Service update failed'];
    }

    // Delete a service
    static public function deleteService($id)
    {
        $service = self::findById($id);

        if (!$service) {
            return ['status' => 'error', 'message' => 'Service not found'];
        }

        $delete_query = $service->delete();

        return $delete_query
            ? ['status' => 'success', 'message' => 'Service deleted successfully']
            : ['status' => 'error', 'message' => 'Service deletion failed'];
    }

    // Retrieve all services
    static public function allServices()
    {
        return self::findAll();
    }

    // Retrieve service by ID
    static public function findServiceById($id)
    {
        return self::findById($id);
    }

    // Retrieve services by category
    static public function findServicesByCategory($category_id)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE category_id = :category_id";
        $stmt = self::executeQuery($sql, ['category_id' => $category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Validation for service fields
    protected function validate()
    {
        $this->errors = [];

        if ($this->is_blank($this->name)) {
            $this->errors[] = "Name cannot be blank.";
        } elseif (strlen($this->name) < 3) {
            $this->errors[] = "Name must be at least 3 characters.";
        }

        if ($this->is_blank($this->description)) {
            $this->errors[] = "Description cannot be blank.";
        }

        if (!is_numeric($this->price) || $this->price < 0) {
            $this->errors[] = "Price must be a positive number.";
        }

        if (empty($this->category_id)) {
            $this->errors[] = "Category is required.";
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
