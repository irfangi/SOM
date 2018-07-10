<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="" method="post">
      <table>
        <tr>
          <td>matrik data</td>
          <td>
            <input type="text" name="mdr" required>
          </td>
          <td>*</td>
          <td>
            <input type="text" name="mdc" required>
          </td>
        </tr>
        <tr>
          <td>matrik bobot</td>
          <td>
            <input type="text" name="mbr" required>
          </td>
          <td>*</td>
          <td>
            <input type="text" name="mbc" required>
          </td>
        </tr>
        <tr>
          <td></td>
          <td><button type="submit" name="button_mat">submit</button></td>
        </tr>
        <tr>
        </tr>
      </table>
    </form>
    <form  action="" method="post">
      <table>
        <tr>
          <td>jumlah iterasi</td><td><input type="text" name="iterasi" required></td><td>alpha</td><td><input type="text" name="alpha" required></td><td>perubahan alpha</td><td><input type="text" name="calpha" required></td>
        </tr>
        <tr>

        </tr>
        <?php
        if (isset($_POST['button_mat'])) {
          $mdr = $_POST['mdr'];
          $mdc = $_POST['mdc'];
          $mbr = $_POST['mbr'];
          $mbc = $_POST['mbc'];
          ?><tr>
          <td>Matriks data</td>
          </tr>
          <?php
          for ($i=0; $i < $mdr; $i++) {
            ?><tr>
            <?php
              for ($c=0; $c < $mdc; $c++) {
                ?>
                  <td><input type="textbox" name="matrixD[<?php echo $i;?>][]" value="" required/> </td>
                <?php
              }
             ?>
          </tr>
          <?php
          }
         ?>
         <tr>
           <td>Matriks bobot</td>
         </tr>
         <?php
         for ($i=0; $i < $mbr; $i++) {
           ?><tr>
           <?php
             for ($c=0; $c < $mbc; $c++) {
               ?>
                 <td><input type="textbox" name="matrixB[<?php echo $i;?>][]" value="" required/> </td>
               <?php
             }
            ?>
         </tr>
         <?php
         }
         ?>
         </table>
         <button type="submit" name="button">submit</button>
       <?php }  ?>
    </form>
<?php
if (isset($_POST['button'])) {

  $data = $_POST['matrixD'];
  $bobot = $_POST['matrixB'];
  $alpha = $_POST['alpha'];
  $iterasi= $_POST['iterasi'];
  $batasColData = 0;
  $batasColBobot = 0;

  foreach ($data as $d) {
    $batasColData=count($d);
    break;
  }
  foreach ($bobot as $b) {
    $batasColBobot = count($b);
    break;
  }

  #ini iterasi yang ditentukan
  for ($per=0; $per<$iterasi; $per++)
  {
      #iterasi array data
      for ($rowdata=0; $rowdata<count($data); $rowdata++)
      {
        $hasildat=0;
        $ind=[];
        for ($colbobot=0; $colbobot<$batasColBobot; $colbobot++)
        {
          $coldata=0;
          $hasil=0;
          #iterasi hitung jarak neuron
          for ($rowbobot=0; $rowbobot<count($bobot); $rowbobot++)
          {
            #rumus jarak neuron
            $hasil=$hasil+(pow($bobot[$rowbobot][$colbobot]-$data[$rowdata][$coldata],2));
            $coldata++;
          }
          #memilih hasil jarak neuron terkecil
          if ($hasildat==0)
          {
            $hasildat=$hasil;
            for ($rowbobot=0; $rowbobot<count($bobot); $rowbobot++)
            {
              $bobotmenang[$rowbobot]=$bobot[$rowbobot][$colbobot];
               $ind1[$rowbobot]=$rowbobot;
               $ind2[$rowbobot]=$colbobot;

            }
          }
          else
          {
            if ($hasil<$hasildat)
            {
              $hasildat=$hasil;
              for ($rowbobot=0; $rowbobot<count($bobot); $rowbobot++)
              {
                $bobotmenang[$rowbobot]=$bobot[$rowbobot][$colbobot];
                $ind1[$rowbobot]=$rowbobot;
                $ind2[$rowbobot]=$colbobot;
              }
            }
          }
        }
          #menghitung bobot baru
          $rowdata=$rowdata;
          for ($coldata=0; $coldata<$batasColData; $coldata++)
          {
            $datahitung[$coldata]=$data[$rowdata][$coldata];
            $hasilhitung1[$coldata]= $datahitung[$coldata]-$bobotmenang[$coldata];
            $hasilhitung2[$coldata]= $alpha * $hasilhitung1[$coldata];
          }
          #mengubah bobot lama yang terpilih dengan bobot baru
          for ($rowbobot=0; $rowbobot<count($bobot); $rowbobot++)
          {
            $hasilakhir[$rowbobot] = $bobotmenang[$rowbobot]+$hasilhitung2[$rowbobot];
            $bobot[$ind1[$rowbobot]][$ind2[$rowbobot]]=$hasilakhir[$rowbobot];
          }
      }
      #mengubah nilai alpha
      $alpha=$alpha*$_POST['calpha'];
  }
  ?>
  <table>
    <tr>
      <td>hasil : </td>
    </tr>
    <?php
      foreach ($bobot as $bot) {
        echo "<tr>";
        foreach ($bot as $b) {
          ?>
            <td><?php echo $b; ?></td>
          <?php
        }
        echo "</tr>";
      }
     ?>
  </table>
  <?php
  //echo count($data);
}
 ?>
</body>
</html>
