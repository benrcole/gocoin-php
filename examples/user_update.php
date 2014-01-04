<?php
    require_once '../src/Api.php';
    require_once '../src/Auth.php';
    require_once '../src/Client.php';

    session_start();

    /*
        Id:    your app client_id
        Secret:    your app secret id
        scope: read scope
    */

    // to test user updates, add '?lastname=NEWLASTNAMEHERE' to the url of this page
    $last_name = isset($_GET['lastname']) ? $_GET['lastname'] : "User2";

    $client = new Client( array(
        'client_id' => "PLACE_YOUR_CLIENT_ID_HERE",
        'client_secret' => "PLACE_YOUR_CLIENT_SECRET_HERE"
    ));

    $b_auth = $client->authorize_api();

    $my_data = array (
        "last_name" => $last_name
    );

    $data_string = json_encode($my_data);

    if ($b_auth) {
        // retrieve user details
        $user = $client->api->user->self();
    } else {
        echo $client->getError();
    }

    if ($user) {
        // stick json encoded array with new last name into params for update
        $update_user_params = array(
            'id' => $user->id,
            'data' => $data_string
        );

        // update the users last name
        $update_user = $client->api->user->update($update_user_params);
        if (!$update_user) {
            echo $client->getError();
        }
    } else {
        echo $client->getError();
    }
?>

<html>
<body>

<?php if ($user) : ?>
    <h4>Pre Update</h4>
    <ul>
        <li>User Id : &nbsp;&nbsp;<?php echo $user->id?></li>
        <li>User Email : &nbsp;&nbsp;<?php echo $user->email?></li>
        <li>Name : &nbsp;&nbsp;<?php echo $user->first_name?>&nbsp;<?php echo $user->last_name?></li>
        <li>Merchant Id :&nbsp;&nbsp;<?php echo $user->merchant_id?></li>
    </ul>
<?php endif;?>

<br><br><br>

<?php if ($update_user) : ?>
    <h4>Post Update</h4>
    <ul>
        <li>User Id : &nbsp;&nbsp;<?php echo $update_user->id?></li>
        <li>User Email : &nbsp;&nbsp;<?php echo $update_user->email?></li>
        <li>Name : &nbsp;&nbsp;<?php echo $update_user->first_name?>&nbsp;<?php echo $update_user->last_name?></li>
        <li>Merchant Id :&nbsp;&nbsp;<?php echo $update_user->merchant_id?></li>
    </ul>
<?php endif;?>
</body>
</html>
