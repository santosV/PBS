<?

if($_POST){

        // Obtenemos los datos en formato variable1=valor1&variable2=valor2&...
        $raw_post_data = file_get_contents('php://input');
 
        // Los separamos en un array
        $raw_post_array = explode('&',$raw_post_data);
 
        // Separamos cada uno en un array de variable y valor
        $myPost = array();
        foreach($raw_post_array as $keyval){
            $keyval = explode("=",$keyval);
            if(count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
 
        // Nuestro string debe comenzar con cmd=_notify-validate
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')){
            $get_magic_quotes_exists = true;
        }
        foreach($myPost as $key => $value){
            // Cada valor se trata con urlencode para poder pasarlo por GET
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value)); 
            } else {
                $value = urlencode($value);
            }
 
            //Añadimos cada variable y cada valor
            $req .= "&$key=$value";
        }

        $ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');   // Esta URL debe variar dependiendo si usamos SandBox o no. Si lo usamos, se queda así.
        //$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');         // Si no usamos SandBox, debemos usar esta otra linea en su lugar.
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
 
        if( !($res = curl_exec($ch)) ) {
            // Ooops, error. Deberiamos guardarlo en algún log o base de datos para examinarlo después.
  
        }
        curl_close($ch);
        if (strcmp ($res, "VERIFIED") == 0) {
            $payment_status = $_POST['payment_status']; 
            $txn_id = $_POST['txn_id']; 
            $receiver_email = $_POST['receiver_email']; 
            $date = date('Y-m-d H:i:s',strtotime($_POST['payment_date']));
            $user = $_POST['item_number']; 
            
            if($payment_status=='Completed' || $payment_status=='Processed' ) { 
                if($receiver_email == 'santosvega.a-facilitator-1@gmail.com'){ 
                   
                }
            }else{ 
              //No se realizó el pago con exito. 
            } 
        } else if (strcmp ($res, "INVALID") == 0) {
            //nel pastel
        } 
}
?>

