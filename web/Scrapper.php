<?php
test("works");
$var1 = $argv[1];
 $all_links= array();
 $checked_links= array();
//GET Domain name from given url
 if(substr($var1, 0, 11) === 'http://www.' || substr($var1, 0, 12) === 'https://www.'|| substr($var1, 0, 4) === 'www.'){
    preg_match_all("~\.([^\W]+)\.[a-z]{1,4}~", $var1, $out2);
}else  preg_match_all("~\.|/([^\W]+)\.[a-z]{1,4}~", $var1, $out2);
 $mainLink= substr($out2[0][0], 1);
//test($mainLink);
 //Check connection type of main url
 if (strpos($var1, "https://") === true)
    {
    $type= "https://";
    }
    else
    {
    $type= "https://";
}
//StartChecking
 getLinks($var1,$mainLink);
//Check One more time with new links
 pickLink($mainLink);
 //Get emails from all links in array
 foreach($all_links as $clink){
     getEmails($clink);
 }
 
//Main function which finds links and calls other functions
 function getLinks($linktouse,$mainLink){
    global $type;
    //Get all content
   $contents= @file_get_contents($linktouse);
   //match text with simple regex
   preg_match_all("~a\shref=\"([^\"]*)\".+~", $contents, $out1);
    //Remove all unnecessary characters and get main domain links 
   foreach ($out1[1] as $value) {
       //echo "$value <br>";
       if (substr($value, 0, 1) !== '#'){
           
           if(substr($value, 0, 2) !== '//' && substr($value, 0, 1) !== '/' && strpos($value, $mainLink) !== false && substr($value, 0, 7) !== 'mailto:'){
               //echo "$value <br>";
               addToLinkList($value);
           }
           if(substr($value, 0, 2) !== '//' && substr($value, 0, 1) === '/'){
               //echo "$type$mainLink$value <br>";
               $newLink = "$mainLink$value";
               addToLinkList($newLink);
           }
       }
       
   }
   
   addCheckedLink($linktouse);
}
//Loop with new links. I choose to do two times
//because more takes more time and full check is very long...
 function pickLink($mainLink){
    pickNewLink($mainLink);
    //pickNewLink($mainLink);
    //pickNewLink($mainLink);
 }
 //Checks if Link was checked and picks  it if not
 function pickNewLink($mainLink){
    global $all_links;
    global $checked_links;
    foreach ($all_links as $value) {
        if (!in_array($value,$checked_links) && strpos($value, $mainLink) !== false)
        {
            getLinks($value,$mainLink);
        }
    }
 }
 //Add link to all link list
function addToLinkList($link){
    global $all_links;
    if (!in_array($link,$all_links))
    {
    array_push($all_links, $link);
   
    }
}
//Add link to all cheked links list
function addCheckedLink($link){
    global $checked_links;
    if (!in_array($link,$checked_links))
    {
    
    array_push($checked_links, $link);
    }
}
//Match emails with given regex and to databse with current url
function getEmails($linktouse){
    $contents= @file_get_contents($linktouse);
    preg_match_all("~[a-z0-9._]+@[a-z]+\.[a-z]{2,3}~",
    $contents,
    $out);
    foreach ($out[0] as $emals){
        sendToDataBase($emals,$linktouse);
    }
}
//test($var1);
    function test($test){
     $servername = "sql11.freemysqlhosting.net";
        $username = "sql11196478";
        $password = "7R2CnJbtGv";
        $dbname = "sql11196478";
        $table = "crawlEmails";
     $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
      $sql = "INSERT INTO $table (url, email)
                    VALUES ('test', '$test')";
                    
                    if ($conn->query($sql) === TRUE) {
                        
                    } else {
                       
                    }
     
     
     
     
    }
function sendToDataBase($email,$currentemail){
    $servername = "sql11.freemysqlhosting.net";
    $username = "sql11196478";
    $password = "7R2CnJbtGv";
    $dbname = "sql11196478";
    $table = "crawlEmails";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //CHECK IF TABLE EXISTS IN DATABASE
    $sql="SELECT * FROM $table";
    $result=$conn->query($sql);
    if (!$result)
    {//IF DOESNT EXIST THEN MAKE ONE
        
        $sql = "CREATE TABLE $table (
        id INT(6) AUTO_INCREMENT PRIMARY KEY,
        url VARCHAR(100) NOT NULL,
        email VARCHAR(30) NOT NULL
        )";
        
        if ($conn->query($sql) === TRUE) {
            //IF CREATED SUCCSESSFULY CHECK IF EMAIL ALREADY EXISTS
            $sql = "SELECT url FROM $table WHERE email='$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {

            }else{
                //IF DOESNT EXIST ADD EMAIL
                $sql = "INSERT INTO $table (url, email)
                VALUES ('$currentemail', '$email')";
                
                if ($conn->query($sql) === TRUE) {
                    
                } else {
                   
                }
            }
        
        } else {
            
        }
    }else {
        //IF TABLE EXIST CHECK IF EMAIL IS ALREADY THERE
        $sql = "SELECT url FROM $table WHERE email='$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {

            }else{
                //IF EMAIL DOESNT EXIST ADD ONE
                $sql = "INSERT INTO $table (url, email)
                VALUES ('$currentemail', '$email')";
                
                if ($conn->query($sql) === TRUE) {
                    
                } else {
                   
                }
            }
    }
    
    $conn->close();
}

?>
