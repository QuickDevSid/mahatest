<?php 
class verifyAuthToken{
    function verifyAuthTokenFunc($token){
        $jwt=new JWT();
        $JWTSecretKey='mahaTestApp';
       $verification=$jwt->decode($token,$JWTSecretKey,'HS256');
        
        $verification_json=$jwt->jsonEncode($verification);
        return $verification_json;
    }
}
    
?>