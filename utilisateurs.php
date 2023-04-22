<?php
    $title = "Photo4You | Admin";
    include_once("./includes/connection.inc.php");
    if($_SESSION['type'] != "admin") { header('Location: index.php'); }

    if(isset($_GET['delete'])) {
        $id = htmlspecialchars($_GET['delete']);
        $nom = htmlspecialchars($_GET['nom']);
        $managerUser->delete($id, $managerPhoto);

        header('Location: utilisateurs.php?error=delete&nom='.$nom.'&id='.$id);
    }

    if(isset($_GET["ban"]) && !empty($_GET['ban'])) {
        $id = htmlspecialchars($_GET['delete']);
        $nom = htmlspecialchars($_GET['nom']);
        $managerUser->banUser(htmlspecialchars($_GET['ban']));
        header('Location: utilisateurs.php?error=banned&nom='.$nom.'&id='.htmlspecialchars($_GET['ban']));
    }

    include_once("./includes/header.inc.php");
    echo generationEntete("Photo4You", "Gérer les ".$managerUser->countUsers()." utilisateurs.");
?>
    <div class="container">
        <?php
            if(isset($_GET['error']) & isset($_GET['nom']) & isset($_GET['id'])) {
                $err = htmlspecialchars($_GET['error']);
                switch($err) {
                    case 'delete':
                        ?>
                            <div class="alert alert-danger text-center">
                                <strong><i class="fas fa-times-circle"></i> Attention :</strong> L'utilisateur <strong><?=htmlspecialchars($_GET['nom'])?> (ID : <?=htmlspecialchars($_GET['id'])?>)</strong> viens d'etre supprimé.
                            </div>
                        <?php
                        break;

                    case 'banned':  
                        ?>
                            <div class="alert alert-warning text-center">
                                <strong><i class="fas fa-times-circle"></i> Attention :</strong> L'utilisateur <strong><?=htmlspecialchars($_GET['nom'])?> (ID : <?=htmlspecialchars($_GET['id'])?>)</strong> viens d'etre bannis.
                            </div>
                        <?php
                        break;

                    default:
                        break;
                }
            }
        ?>
        <div class="input-group">
            <span class="input-group-text">Rechercher un utilisateur</span>
            <input type="text" class="form-control" id="myInput" onkeyup="searchShortcut()" placeholder="Rechercher un utilisateur...">
        </div>
        <table class="table table-striped table-hover text-center table-light">
            <thead>
                <tr>
                    <th scope="col" class="text-decoration-underline">ID</th>
                    <th scope="col" class="text-decoration-underline">Nom</th>
                    <th scope="col" class="text-decoration-underline">Prénom</th>
                    <th scope="col" class="text-decoration-underline">Role</th>
                    <th scope="col" class="text-decoration-underline">Action</th>
                </tr>
            </thead>
            <tbody id="racourci-container">
                <?php
                    foreach ($managerUser->getNonBannedList() as $user):
                ?>
                <tr class='racourci'>
                    <td class='racourci-title'><?=$user['Id']?></td>
                    <td class='racourci-title'><?=ucfirst($user['Nom'])?></td>
                    <td class='racourci-title'><?=ucfirst($user['Prenom'])?></td>
                    <td class='racourci-title'><?=ucfirst($user['Type'])?></td>
                    <td class='racourci-title'>
                        <a title="Supprimer cet utilisateur" class="btn btn-danger" href="./utilisateurs.php?delete=<?=$user['Id']?>&nom=<?=$user['Nom']?>" role="button"><i class="fa-solid fa-circle-xmark"></i></a>
                        <a title="Bannir cet utilisateur" class="btn btn-warning" href="./utilisateurs.php?ban=<?=$user['Id']?>&nom=<?=$user['Nom']?>" role="button"><i class="fa-solid fa-ban"></i></a>
                    </td>
                </tr>
                <?php
                    endforeach;
                ?>

                <tr id='noresult' style="display: none;">
                    <td colspan='5' class="fw-bolder bg-warning">Aucun résultat</td>
                </tr>
            </tbody>
        </table>
        
    </div>
<?php
    include_once("./includes/footer.inc.php");
?>