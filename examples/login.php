<?php
    require_once '../src/Api.php';
    require_once '../src/Auth.php';
    require_once '../src/Client.php';

    session_start();

    /*
        Id      : your app client_id
        Secret  : your app secret id
        scope   : token scope
    */

    $headers = array(
        "'Content-Type' => 'application/json'",
        "'Content-Type' => 'application/text'"
    );

    $client = new Client( array(
        'client_id' => "PLACE_YOUR_CLIENT_ID_HERE",
        'client_secret' => "PLACE_YOUR_CLIENT_SECRET_HERE",
        'scope' => "user_read_write invoice_read_write",
        'redirect_uri' => "PUT_YOUR_URL_HERE",
        'headers' => $headers
    ));

    $client->initToken();
    $b_auth = $client->authorize_api();

    if ($b_auth) {
        $token = $client->getToken();
        echo "Access Token: ".$token;
    } else {
        echo $client->getError();
    }

?>

<html>
<body>
    <?php if (!$b_auth) : ?>
        <a href="<?php echo $client->get_auth_url();?>">Login Go Coin</a>
    <?php endif;?>
</body>
</html>
