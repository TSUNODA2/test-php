<!DOCTYPE html>
<?php

$bdd = new PDO('mysql:host=Localhost;dbname=test 2', 'root', '');

if(isset($_POST['forminscription']))
{
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $Email = htmlspecialchars($_POST['Email']);
        $confirmationEmail = htmlspecialchars($_POST['confirmationEmail']);
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);
        if(!empty($_POST['pseudo']) AND !empty($_POST['Email']) AND !empty($_POST['confirmationEmail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {

        $pseudolength = strlen($pseudo);
        if($pseudolength <= 255)
        {

            if($Email == $confirmationEmail)
            {
              if(filter_var($Email, FILTER_VALIDATE_EMAIL))
               {
                   $reqmail = $bdd->prepare("SELECT * FROM mdr WHERE Email = ?");
                   $reqmail->execute(array($Email));
                   $mailexist = $reqmail->rowCount();
                 
                   if($mailexist == 0)
                   {

                        if($mdp == $mdp2)
                         {
                         $insertmbr = $bdd->prepare("INSERT INTO mdr(pseudo, email, mdp) VALUES (?, ?, ?)");
                         $insertmbr->execute(array($pseudo, $Email, $mdp));
                         $erreur = "Votre compte a bien etait crée !";
                         }
                        else{
                         $erreur = "Vos mots de passes ne correspondent pas !!";
                         }
                       }
                       else
                       {
                           $erreur = "Adresse mail deja utiliser !";
                       }
                     }  
                 else{
                 $erreur = "Votre adresse mail n'est pas valide";
                }    
            }
            else{
                $erreur = "Vos adresses Email ne correspondent pas !";
               }
             }
        
        else{
            $erreur = "Votre pseudo ne doit pas depasser les 255 caracteres !";
             }
        
            }   
     else
    {
        $erreur = "Tous les champs doit etre completees !";
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test php</title>
</head>
<body>
    <div align="center">
        <h1>inscription</h1>
        <br /><br />
         <form method="POST" action="">
             <table>
                 <tr>
                     <td align="right">
                         <label for="pseudo">Pseudo :</label>

                     </td>

                     <td>
                         <input type="text" name="pseudo" id="pseudo" placeholder="entrer votre pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>">
                     </td>
                 </tr>

          <br>

                 <tr>
                     <td align="right">
                         <label for="pseudo">Email :</label>

                     </td>

                     <td>
                         <input type="Email" name="Email" id="Email" placeholder="entrer votre Email" value="<?php if(isset($Email)) { echo $Email; } ?>">
                     </td>
                 </tr>

         <br>

                 <tr>
                     <td align="right">
                         <label for="confirmationEmail">Confirmation Email :</label>

                     </td>

                     <td>
                         <input type="Email" name="confirmationEmail" id="confirmationEmail" placeholder="confirmez votre Email" value="<?php if(isset($confirmationEmail)) { echo $confirmationEmail; } ?>">
                     </td>
                 </tr>

                 <tr>
                     <td align="right">
                         <label for="mdp">mot de passe :</label>

                     </td>

                     <td>
                         <input type="password" name="mdp" id="mdp" placeholder="entrer votre mot de passe">
                     </td>
                 </tr>

                 <td align="right">
                         <label for="mdp2">confirmez votre mot de passe :</label>

                     </td>

                     <td>
                         <input type="password" name="mdp2" id="mdp2" placeholder="confirmez votre mdp">
                     </td>
                 </tr>
          </table>
          <br />
          <input type="submit" name="forminscription" value="s'inscrire">
          </form>
          <?php
            
            if(isset($erreur))
            {
                echo '<font color = "red">'.$erreur. "</font>";
            }

          ?>
    </div>
</body>
</html>