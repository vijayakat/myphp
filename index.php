<!DOCTYPE html>
<html>
<head>
    <title>PHP Starter Application</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
if( getenv( "VCAP_SERVICES" ) )
{
    # Get database details from the VCAP_SERVICES environment variable
    #
    # *This can only work if you have used the Bluemix dashboard to 
    # create a connection from your dashDB service to your PHP App.
    #
    $details  = json_decode( getenv( "VCAP_SERVICES" ), true );
    $dsn      = $details [ "dashDB" ][0][ "credentials" ][ "dsn" ];
    $ssl_dsn  = $details [ "dashDB" ][0][ "credentials" ][ "ssldsn" ];

    # Build the connection string
    #
    $driver = "DRIVER={IBM DB2 ODBC DRIVER};";
    $conn_string = $driver . $dsn;     # Non-SSL
    $conn_string = $driver . $ssl_dsn; # SSL

    $conn = db2_connect( $conn_string, "", "" );
    if( $conn )
    {
        echo "<p>Connection successful.</p>";
        db2_close( $conn );
    }
    else
    {
        echo "<p>Connection failed.</p>";
    }
}
else
{
    echo "<p>No credentials.</p>";
}
?>
</body>
</html>