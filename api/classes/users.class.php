<?php

class Users extends DatabaseObject
{
    // Table name
    static protected $table_name = "users";

    // Database columns
    static protected $db_columns = ['id', 'name', 'email', 'password', 'phone', 'role', 'created_at', 'updated_at'];

    // Class properties for each column
    public $id;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $role; // 'user' or 'pro'
    public $created_at;
    public $updated_at;

    // Constructor
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->role = $args['role'] ?? 'user'; // Default role is 'user'
        $this->created_at = $args['created_at'] ?? null;
        $this->updated_at = $args['updated_at'] ?? null;
    }

    // Register a new user
    static public function register($data)
    {
        $passwordHash = new PasswordHash();
        $passwordHashed = isset($data["password"]) ? $passwordHash->hash($data["password"]) : '';

        $user = new self($data);
        $user->password = $passwordHashed;

        $errors = $user->validate();
        if (!empty($errors)) {
            return ['status' => 'error', 'message' => 'Validation failed', 'errors' => $errors];
        }

        $save_query = $user->save();

        return $save_query
            ? ['status' => 'success', 'message' => 'User registered successfully']
            : ['status' => 'error', 'message' => 'Registration failed'];
    }

    // Verify user login
    static public function login($email, $password)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE email = :email";
        $stmt = self::executeQuery($sql, ['email' => $email]);
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            $user = static::instantiate($user_data);
            $passwordHash = new PasswordHash();

            if ($passwordHash->verify($password, $user->password)) {
                $tokenData = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role
                ];
                $token = JWT::generateToken($tokenData);

                return [
                    'status' => 'success',
                    'message' => 'Login successful',
                    'user' => $user,
                    'token' => $token
                ];
            } else {
                return ['status' => 'error', 'message' => 'Invalid password'];
            }
        }

        return ['status' => 'error', 'message' => 'User not found'];
    }

    // Retrieve all users
    static public function allUsers()
    {
        return self::findAll();
    }

    // Retrieve user by ID
    static public function findUserById($id)
    {
        return self::findById($id);
    }

    // Validation for user fields
    protected function validate()
    {
        $this->errors = [];

        if ($this->is_blank($this->name)) {
            $this->errors[] = "Name cannot be blank.";
        } elseif (strlen($this->name) < 3) {
            $this->errors[] = "Name must be at least 3 characters.";
        }

        if ($this->is_blank($this->email)) {
            $this->errors[] = "Email cannot be blank.";
        } elseif (!$this->has_valid_email_format($this->email)) {
            $this->errors[] = "Email must be a valid format.";
        }

        if ($this->is_blank($this->password)) {
            $this->errors[] = "Password cannot be blank.";
        } elseif (strlen($this->password) < 8) {
            $this->errors[] = "Password must be at least 8 characters.";
        }

        return $this->errors;
    }

    // Helper functions
    private function is_blank($value)
    {
        return !isset($value) || trim($value) === '';
    }

    private function has_valid_email_format($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

?>