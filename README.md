# IIM_A2_GIT

# ISSUE 1

Login
------
* Permettre aux utilisateurs de se connecter sur le site. À réaliser sur une nouvelle branche : login.
* Dans le fichier view/login.php :
* Modifiez le formulaire et ajouter les attributs "name" aux différents inputs.
* Vérifiez vos changements avec $ git diff et $ git status
* Commitez. Indiquez "Ajout des balises 'name' au formulaire de Login. #1" comme message de commit.
* Dans le fichier login.php :
* Vérifiez que les champs de vos formulaires sont bien définis et ne sont pas vide pour exécuter la suite du code de login.
* Récupérer les informations du formulaire avec $_POST.
* Modifiez l'appel à méthode userConnection() pour y inclure les données récupérées du formulaire. Si la méthode renvoie true, les identifiants sont bons, rediriger vers dashboard.php
* Si la méthode renvoie false, les identifiants sont faux, stocker un message d'erreur "Mauvais identifiants" dans une variable $error
* Tester et retester.
* Une fois que tout est fonctionne :
* Vérifiez vos changements avec $ git diff et $ git status
* Commitez. Indiquez "Finalisation du Login. Fix #1" comme message de commit Pushez sur la branche login.
* Enfin, fusionnez la branche login dans la branche master, puis pushez sur master. (n'oublier pas de récupérer les potentiels changements en faisant un git pull)


# ISSUE 2
Inscription
------
* Permettre aux utilisateurs de créer un compte sur le site. À réaliser sur une nouvelle branche : register.
* Étapes
* Dans le fichier view/register.php :
* Modifiez le formulaire et ajouter les attributs "name" aux différents inputs.
* Vérifiez vos changements avec $ git diff et $ git status
* Commitez. Indiquez "Ajout des balises 'name' au formulaire d'inscription. #2" comme message de commit.
* Dans le fichier register.php :
* Vérifiez que les champs de vos formulaires sont bien définis et ne sont pas vide pour exécuter la suite du code d'inscription.
* Récupérer les informations du formulaire avec $_POST
* Vérifier que l'username et l'email sont disponibles en appelant les méthodes isUsernameAvailable() et isEmailAvailable()
* Quand les 2 sont dispos, modifiez l'appel à la méthode userRegistration() pour y inclure les données récupérées du formulaire.
* Si l'email n'est pas disponible, stockez un message d'erreur "Email indisponible" dans une variable $error.
* Si l'username n'est pas disponible, stockez un message d'erreur "Username indisponible" dans une variable $error.
* Tester et retester.
* Une fois que tout est OK :
* Vérifiez vos changements avec $ git diff et $ git status
* Commitez. Indiquez "Finalisation de l'inscription. Fix #2" comme message de commit Pushez.
* Enfin, fusionnez la branche register dans la branche master, puis pushez sur master. (n'oublier pas de récupérer les potentiels changements en faisant un git pull)





