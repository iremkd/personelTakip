<!DOCTYPE html>
<?php 
    //Database Bağlantısı
$kadi = "root";
$sifre = "";
$database = "istakip";
try {
    $db = new PDO("mysql:host=localhost;dbname=$database;charset=UTF8;", $kadi, $sifre);
} catch (PDOException $e) {
    echo $e->getMessage();
}

    //İşçileri Çek
$isciler = $db->prepare("select * from isciler");
$isciler->execute();
$isci = $isciler->fetchAll(PDO::FETCH_OBJ);

    //Boşta Olan İşçiler
$bosIsciler = $db->prepare("select * from isciler where durum=0");
$bosIsciler->execute();
$bosIsci = $bosIsciler->fetchAll(PDO::FETCH_OBJ);

    //İşleri Çek
$isler = $db->prepare("select * from isler");
$isler->execute();
$is = $isler->fetchAll(PDO::FETCH_OBJ);

    //Boştaki İşler
$bosIsler = $db->prepare("select * from isler where durum=0");
$bosIsler->execute();
$bosIs = $bosIsler->fetchAll(PDO::FETCH_OBJ);

?>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İş Takip Otomasyonu</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>  

</head>
<body>
    <div class="row m-2 w-100">

        <!--İşçi Paneli -->
        <div class="col-3 mt-2">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">İşçi Paneli</h5><hr>
                    <p class="card-body">
                        <form class="form-group" method="post" id="isci-kayit">
                            <label for="adi">Adı Soyadı</label><input class="form-control" type="text" name="adi" id="adi" required>
                            <label for="tel">Cep Numarası</label><input class="form-control mt-2" type="text" name="tel" id="tel" required>
                            <label for="dtarih">D. Tarihi</label><input class="form-control mt-2" type="date" name="dtarih" id="dtarih" required value="<?=date('Y-m-d'); ?>" required>
                            <button type="submit" name="isciKayit" class="btn btn-success mt-2 w-100">Kaydet</button>
                        </form>
                    </p>
                </div>
            </div>
        </div>

        <!-- İş Paneli -->
        <div class="col-3 mt-2">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">İş Paneli</h5><hr>
                    <p class="card-body">
                        <form class="form-group" method="post">
                            <label for="isadi">İş Adı</label><input class="form-control" type="text" name="isadi" id="isadi">
                            <label for="istarih">Tamamlanma Tarihi</label><input class="form-control mt-2" type="date" name="istarih" id="istarih" value="<?=date('Y-m-d'); ?>">
                            <label for="personel">Personel</label>
                            <select class="form-control mt-2" name="personel" id="personel" required>
                                <option value="0">Tanımlama</option>
                                <?php 
                                foreach($bosIsci as $isciBu){
                                    ?>
                                    <option value="<?php echo $isciBu->id;?>"><?php echo $isciBu->adsoyad;?></option>
                                    <?php
                                }
                                ?>

                            </select>
                            <button type="submit" name="iskaydet" class="btn btn-success mt-2 w-100">Kaydet</button>
                        </form>
                    </p>
                </div>
            </div>
        </div>

        <!--Boştaki İşler -->
        <div class="col-3 mt-2">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">Boştaki İşler</h5><hr>
                    <p class="card-body">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>İş Adı</th>
                                    <th>Son Tarih</th>
                                    <th class="text-center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach($bosIs as $ids){
                                    ?>
                                    <tr>
                                        <td><?php echo $ids->isadi;?></td>
                                        <td><?php echo $ids->starih;?></td>
                                        <td class="text-center"><a href="?issil=<?php echo $ids->id;?>"><i class="fa fa-trash text-danger" title="İşi Sil"></i></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </p>
                </div>
            </div>
        </div>
        <!-- İşçiler -->
        <div class="col-3 mt-2">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title text-center">İşçi Takip</h5><hr>
                    <p class="card-body">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>İşçi Adı</th>
                                    <th>Durum</th>
                                    <th class="text-center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach($isci as $idf){
                                    ?>
                                    <tr>
                                        <td><?php echo $idf->adsoyad;?></td>
                                        <td><?php 
                                        if($idf->durum == 2) {
                                            ?><span class="badge bg-danger">Çalışamaz</span><?php
                                        }
                                        elseif($idf->durum == 1){
                                            ?><span class="badge bg-success">Çalışıyor..</span><?php
                                        }
                                        else{
                                            ?><span class="badge bg-warning">Boşta</span><?php
                                        }
                                    ?></td>
                                    <td class="text-center"><a href="?iscisil=<?php echo $idf->id ?>"><i class="fa fa-trash text-danger" title="İşi Sil"></i></a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </p>
            </div>
        </div>
    </div>

    <!-- Genel Takip Paneli -->
    <div class="row">
        <div class="col">
            <div class="col mt-2">
                <div class="card w-100" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Takip Paneli</h5><hr>
                        <p class="card-body">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th>İş Adı</th>
                                        <th>Sonlanma Tarihi</th>
                                        <th>Atanan Personel</th>
                                        <th>Durum</th>
                                        <th class="text-center">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($is as $idz){
                                        if($idz->starih < date('Y-m-d')){
                                            $sorgu = $db->prepare("UPDATE isler SET durum = :durum where id=".$idz->id);
                                            $isTamamlandi = $sorgu->execute(array("durum" => 2));
                                        }


                                        ?>
                                        <tr>
                                            <td><?php echo $idz->isadi;?></td>
                                            <td><?php echo date('d-m-Y',strtotime($idz->starih));?></td>
                                            <td><?php 
                                            if($idz->atanan==0){
                                            ?><span class="badge bg-danger">Atama Yapılmadı</span>
                                            <?php  
                                            if($idz->atanan==0 and $idz->durum!=2){ ?>
                                             <form method="POST">
                                                <div class="d-flex align-items-center">
                                                    <input type="hidden" name="is_id" value="<?=$idz->id; ?>">
                                                    <select class="form-control form-control-sm" name="personel">
                                                        <?php 
                                                        foreach($isci as $isciBu){
                                                            ?>
                                                            <option value="<?php echo $isciBu->id;?>"><?php echo $isciBu->adsoyad;?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <button type="submit" name="is_ata" class="btn btn-success btn-sm">Ata</button>
                                                </div>
                                            </form> 
                                        <?php }
                                    }
                                    else{

                                        $isciBilgi = $db->query("SELECT * FROM isciler WHERE id=".$idz->atanan)->fetch(PDO::FETCH_ASSOC);
                                        echo $isciBilgi['adsoyad'];
                                    }
                                ?></td>
                                <td><?php 
                                if($idz->durum == 2) {
                                    ?><span class="badge bg-success">Tamamlandı</span><?php

                                }
                                elseif($idz->durum == 1){
                                    ?><span class="badge bg-warning">Devam Ediyor..</span><?php

                                }
                                else{
                                    ?><span class="badge bg-danger">Tamamlanmadı</span><?php
                                }
                            ?></td>
                            <td class="text-center"><a href="?gtamam=<?php echo $idz->id ?>&isci=<?php echo $idz->atanan ?>"><i class="fa fa-check text-success" title="İşi Tamamla"></i></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>

            </table>
        </p>
    </div>
</div>
</div>
</div>
</div>
</div>

<?php 
    // İşçi Kaydet
if(isset($_POST['isciKayit'])){
    $data = [
        'adi' => $_POST["adi"],
        'tel' => $_POST["tel"],
        'dtarih' => $_POST["dtarih"]
    ];
    $isciKaydet= $db->prepare("INSERT INTO isciler (adsoyad, cep, dtarih) VALUES (:adi, :tel, :dtarih)");
    $isciKaydet->execute($data);
    if($isciKaydet){
        ?><script>alert("İşçi Kaydı Başarılı !");
        window.location.replace("index.php");</script><?php 
    }
}

    //İşKaydet
if(isset($_POST['iskaydet'])){
    if($_POST["personel"] == 0){


        if($_POST["istarih"] < date('Y-m-d')){
         $data = [
            'isadi' => $_POST["isadi"],
            'personel' => $_POST["personel"],
            'istarih' => $_POST["istarih"]
        ];
        $isKaydet= $db->prepare("INSERT INTO isler (isadi, starih, atanan, durum) VALUES (:isadi, :istarih, :personel, 2)");
        $isKaydet->execute($data);
        if($isKaydet){
            ?><script>alert("İş Kaydı Başarılı !");
            window.location.href = "index.php";</script><?php 
        }
    }
    else {


        if($_POST["istarih"] < date('Y-m-d')){
            $data = [
                'isadi' => $_POST["isadi"],
                'personel' => $_POST["personel"],
                'istarih' => $_POST["istarih"]
            ];
            $isKaydet= $db->prepare("INSERT INTO isler (isadi, starih, atanan, durum) VALUES (:isadi, :istarih, :personel, 2)");
            $isKaydet->execute($data);
            if($isKaydet){
                ?><script>alert("İş Kaydı Başarılı !");
                window.location.href = "index.php";</script><?php 
            }
        }
        else {
            $data = [
                'isadi' => $_POST["isadi"],
                'personel' => $_POST["personel"],
                'istarih' => $_POST["istarih"]
            ];
            $isKaydet= $db->prepare("INSERT INTO isler (isadi, starih, atanan, durum) VALUES (:isadi, :istarih, :personel, 0)");
            $isKaydet->execute($data);
            if($isKaydet){
                ?><script>alert("İş Kaydı Başarılı !");
                window.location.href = "index.php";</script><?php 
            }
        }

    }

}
else{

    if($_POST["istarih"] < date('Y-m-d')){
        $data = [
            'isadi' => $_POST["isadi"],
            'personel' => $_POST["personel"],
            'istarih' => $_POST["istarih"]
        ];
        $isKaydet= $db->prepare("INSERT INTO isler (isadi, starih, atanan, durum) VALUES (:isadi, :istarih, :personel, 2)");
        $isKaydet->execute($data);

        $sorgu = $db->prepare("UPDATE isciler SET durum = :durum where id=".$_POST["personel"]);
        $isciGuncelle = $sorgu->execute(array("durum" => 1));

        if($isciGuncelle and $isKaydet){
            ?><script>alert("İş Kaydı Başarılı !");
            window.location.href = "index.php";</script><?php 
        }
    }
    else {
        $data = [
            'isadi' => $_POST["isadi"],
            'personel' => $_POST["personel"],
            'istarih' => $_POST["istarih"]
        ];
        $isKaydet= $db->prepare("INSERT INTO isler (isadi, starih, atanan, durum) VALUES (:isadi, :istarih, :personel, 1)");
        $isKaydet->execute($data);

        $sorgu = $db->prepare("UPDATE isciler SET durum = :durum where id=".$_POST["personel"]);
        $isciGuncelle = $sorgu->execute(array("durum" => 1));

        if($isciGuncelle and $isKaydet){
            ?><script>alert("İş Kaydı Başarılı !");
            window.location.href = "index.php";</script><?php 
        }
    }
    

}
}


    //işçisil
if(isset($_GET["iscisil"])){
    $iscisil= $db->prepare("DELETE FROM isciler WHERE id=?");
    $iscisil->execute([$_GET["iscisil"]]);
    if($iscisil){
    ?><script>
        alert('İşçi Kaydı Silindi!');
        window.location.replace("index.php");
        </script><?php 
    }
}

    //iş sil
if(isset($_GET["issil"])){
    $issil= $db->prepare("DELETE FROM isler WHERE id=?");
    $issil->execute([$_GET["issil"]]);
    if($issil){
    ?><script>
        alert('İş Kaydı Silindi!');
        window.location.replace("index.php");
        </script><?php 
    }
}

    //işi tamamla
if(isset($_GET["gtamam"])){
    $istamam= $db->prepare("UPDATE isler set durum = 2 WHERE id=?");
    $istamam->execute([$_GET["gtamam"]]);

    $sorgu = $db->prepare("UPDATE isciler SET durum = :durum where id=".$_GET["isci"]);
    $isciGuncelle = $sorgu->execute(array("durum" => 0));


    if($istamam){
    ?><script>
        alert('İş Tamamlandı!');
        window.location.replace("index.php");
        </script><?php 
    }
}



if(isset($_POST['is_ata'])){
    $sorgu = $db->prepare("UPDATE isler SET durum = :durum, atanan =:atanan where id=".$_POST["is_id"]);
    $isGuncelle = $sorgu->execute(array("durum" => 1,"atanan" => $_POST['personel']));
    if($isGuncelle){
        ?><script>alert("İş Güncellemesi Başarılı !");
        window.location.href = "index.php";</script><?php 
    }


}
?>
</body>
</html>

<script>  
    $(document).ready(function(){  

        $('#tel').inputmask('(999)-999-9999');
    });  
</script>  