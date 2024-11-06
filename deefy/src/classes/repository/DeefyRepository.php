<?php
namespace iutnc\deefy\repository;
use iutnc\deefy\audio\lists as lists;
use iutnc\deefy\audio\tracks as tracks;
use iutnc\deefy\auth as auth;
class DeefyRepository{
    private \PDO $pdo;
    private static ?DeefyRepository $instance = null; private static array $config = [ ];
    private function __construct(array $conf) {
        $dsn = self::$config['drive'].":host=" .self::$config['host'] . ";dbname=".self::$config['database'];
        $this->pdo = new \PDO($dsn, self::$config['user'], self::$config['pass'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }
    public static function getInstance(){
        if (is_null(self::$instance)) {
            self::$instance = new DeefyRepository(self::$config);
        }
        return self::$instance;
    }

    public static function setConfig(string $file) {
        $conf = parse_ini_file($file);
        if ($conf===false) {
           throw new \Exception("Error reading configuration file");
        }
        
        self::$config = [ 'database'=> $conf["database"],'user'=> $conf['username'], 'pass'=> $conf['password'],'host' =>$conf['host'],"drive"=>$conf['drive']];
    }


public function findMultyPlaylists($usr){
    $stmt = $this ->pdo->prepare("SELECT playlist.id FROM playlist INNER JOIN user2playlist on id = id_pl where id_user = :usr ");
    $stmt->bindParam(':usr', $usr);
    $stmt->execute();
    $array = [];
    $i = 0;
    $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    foreach($results as $row){
        $p = self::findPlaylistById($row['id']);
        $array[$i] = $p;
        $i++;
    }
    return $array;
}

public function findAllPlaylists(){
    $stmt = $this ->pdo->prepare("SELECT id FROM playlist");
    $stmt->execute();
    $array = [];
    $i = 0;
    $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    foreach($results as $row){
        $p = self::findPlaylistById($row['id']);
        $array[$i] = $p;
        $i++;
    }
    return $array;
}

public function findPlaylistById(int $id): lists\Playlist {
    $stmt = $this ->pdo->prepare("SELECT id,nom FROM playlist where id = ?");
    $stmt->bindParam(1,$id);
    $stmt->execute();
    $resultats = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    foreach ($resultats as $row) {
        $p = new lists\Playlist($row['nom'],$this->findAllTracks());
        $p->setId($id);
    }
    return $p;
}
public function findAllTracks(){
    $stmt = $this ->pdo->prepare("SELECT id FROM Track");
    $stmt->execute();
    $array = [];
    $i = 0;
    $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    foreach($results as $row){
        $p = self::findTrackById($row['id']);
        $array[$i] = $p;
        $i++;
    }
    return $array;
}
public function findTrackById(int $id): tracks\AudioTrack{
    $stmt = $this ->pdo->prepare("SELECT * FROM track where id = ?");
    $stmt->bindParam(1,$id);
    $stmt->execute();
    $resultats = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    foreach ($resultats as $row) {
        if ($row['type'] == 'A'){
            $t = new tracks\AlbumTrack($row['titre'],"music/".$row['filename'],$row['titre_album'],$row['numero_album'],$row['duree']);
            $t->setArtiste($row["artiste_album"]);
        }else{
            $t = new tracks\PodcastTrack($row['titre'],$row['filename'],$row['auteur_podcast'],$row['date_posdcast'],$row['duree'],$row['genre']);
        }
        $t->setId($id);
    }
    return $t;
}


    public function saveEmptyPlaylist(lists\Playlist $pl): lists\Playlist {
        $usr = auth\AuthnProvider::getSignInUser(); 
        $stmt = $this ->pdo->prepare("insert into playlist(nom) values(?)");
        $n = $pl->__get("nom");
        $stmt->bindParam(1,$n);
        $stmt->execute();
        $stmt = $this ->pdo->prepare("select max(id) from playlist");
        $stmt->execute();
        $id = $stmt->fetchColumn();
        $pl->setId($id);
        $stmt = $this->pdo->prepare("insert into user2playlist(id_user,id_pl) values(:usr,:pl)");
        $usr = $this->getIdUser($usr);
        $stmt->bindParam(':usr', $usr);
        $stmt->bindParam(':pl', $id);
        $stmt->execute();
        return $pl;
    }
    public function getPlaylist(){
        $stmt = $this ->pdo->prepare("select * from Playlist");
        $stmt->execute();
        $a = [];
        $resultats = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($resultats as $row) {
            $a[$row["id"]]=$row["nom"];
        }
        return $a;
    }

    public function addTrack(tracks\AudioTrack $track){
    
        
        $b = "iutnc\\deefy\\audio\\tracks\\AlbumTrack";
        if (get_class($track) == $b){
            $titre = $track->__get("titre");
            $genre = $track->__get("genre");
            $duree = $track->__get("duree");
            $nomFich = $track->__get("nom_du_fichier");
            $artiste = $track->__get("artiste");
            $album = $track->__get("album");
            $annee = $track->__get("annee");
            $type = "A";
            $numero = $track->__get("numero_piste");
            $sql = "Insert into track (titre,genre,duree,filename,type,artiste_album,titre_album,numero_album) values(:titre,:genre,:duree,:fname,:type,:artiste,:titreA,:num)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':duree', $duree);
            $stmt->bindParam(':fname', $nomFich);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':artiste', $artiste);
            $stmt->bindParam(':titreA', $album);
            $stmt->bindParam(':num', $numero);
            $stmt->execute();
            $stmt = $this ->pdo->prepare("select max(id) from track");
            $stmt->execute();
            $id = $stmt->fetchColumn();
            $track->setId($id);
        }else{
            $titre = $track->__get("titre");
            $genre = $track->__get("genre");
            $duree = $track->__get("duree");
            $nomFich = $track->__get("nom_du_fichier");
            $auteur = $track->__get("auteur");
            $date = $track->__get("date");
            $type = "P";
            $sql = "Insert into track (titre,genre,duree,filename,type,auteur_podcast,date_posdcast) values(:titre,:genre,:duree,:fname,:type,:auteur,:date)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':duree', $duree);
            $stmt->bindParam(':fname', $nomFich);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':auteur', $auteur);
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            $stmt = $this ->pdo->prepare("select max(id) from track");
            $stmt->execute();
            $id = $stmt->fetchColumn();
            $track->setId($id);
        }
        return $track;
        
    
    }
    public function addTrackToPlaylist(int $idPl, int $idTr){
        $sql = "select count(*) from playlist2track where id_pl = :idp";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idp', $idPl);
        $stmt->execute();
        $nbTrack = $stmt->fetchColumn() + 1; //nombre de musique déjà dans la playlist
        $sql = "select count(*) from playlist2track where id_pl = :idp and id_track = :idt";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idp', $idPl);
        $stmt->bindParam(':idt', $idTr);
        $stmt->execute();
        $verifTrack = $stmt->fetchColumn(); //nombre de musique déjà dans la playlist
        if($verifTrack == 0){
            $sql = "insert into playlist2track(id_pl,id_track,no_piste_dans_liste) values(:idpl,:idt,:no)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idpl', $idPl);
            $stmt->bindParam(':idt', $idTr);
            $stmt->bindParam(':no',$nbTrack);
            $stmt->execute();
        }
    }
    public function verifIdRegister(String $email) : array{
        $sql ="select count(*) from user where email = :email ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $result = $stmt->fetchColumn(); 
        if ($result == 0){
            return [true,null];
        }
        $stmt = $this->pdo->prepare("select passwd from user where email = :email");
        $stmt->bindParam(':email',$email);
        $stmt->execute();
        $passwd = $stmt->fetchColumn();
        return[false,$passwd];
    }

    public function register(String $email,string $password){
        $sql ="insert into user(email,passwd,role) values(:email,:pwd,:role)";
        $role = 1;
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':pwd',$password);
        $stmt->bindParam(':role',$role);
        $stmt->execute();
    }
    public function getIdUser(String $email){
        $stmt = $this ->pdo->prepare("select id from user where email = ?");
        $stmt->bindParam(1,$email);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        return $id;
    }
    public function getRoleUser(String $email){
        $stmt = $this ->pdo->prepare("select role from user where email = ?");
        $stmt->bindParam(1,$email);
        $stmt->execute();
        $id = $stmt->fetchColumn();
        return $id;
    }
}