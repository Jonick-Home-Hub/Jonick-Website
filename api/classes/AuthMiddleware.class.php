<?php
class AuthMiddleware {

    public static function verifyToken() {
        $headers = apache_request_headers();
        if(isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $userData = JWT::validateToken($token);
            
            if($userData) {
                return $userData; // Token is valid
            }
        }
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
        exit;
    }

}
?>
