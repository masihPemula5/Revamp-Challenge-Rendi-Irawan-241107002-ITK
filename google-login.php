<?php
session_start();
include 'db.php';

if (isset($_GET['code'])) {
    $client_id = '276617149835-tu30ido5i0rn1q8jnmm6nnkiouqk7jja.apps.googleusercontent.com';
    $client_secret = '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';
    $redirect_uri = 'http://localhost/UAS/google-login.php';


    $token_request = [
        'code' => $_GET['code'],
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_request));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $token_data = json_decode($response, true);

    if (isset($token_data['access_token'])) {
        $access_token = $token_data['access_token'];

        // Ambil data user dari Google
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v2/userinfo');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $user_info_response = curl_exec($ch);
        curl_close($ch);

        $user_info = json_decode($user_info_response, true);

        if (isset($user_info['email']) && isset($user_info['name'])) {
            
            $_SESSION['email'] = $user_info['email'];
            $_SESSION['username'] = $user_info['name'];

            /
            $email = $user_info['email'];
            $username = $user_info['name'];

            
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
    
                $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
            }

 
            header('Location: crud/crud.php');
            exit();
        } else {
            echo 'Error retrieving user info.';
        }
    } else {
        echo 'Error retrieving access token.';
    }
}
?>
