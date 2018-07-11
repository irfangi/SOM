<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="" method="post">
      <table
      	<tr>
      		<td></td>
      		<td>Baris</td>
      		<td></td>
      		<td>Kolom</td>
  		</tr>
        <tr>
          <td>Matrik data</td>
          <td>
            <input type="text" name="mdr" required>
          </td>
          <td>X</td>
          <td>
            <input type="text" name="mdc" required>
          </td>
        </tr>
        <tr>
          <td>Matrik bobot</td>
          <td>
            <input type="text" name="mbr" required>
          </td>
          <td>X</td>
          <td>
            <input type="text" name="mbc" required>
          </td>
        </tr>
        <tr>
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
        <?php
        if (isset($_POST['button_mat'])) {?>
        <tr>
          <td>jumlah iterasi</td><td><input type="text" name="iterasi" required></td>
        </tr>
        <tr>
          <td>alpha</td><td><input type="text" name="alpha" required></td>
        </tr>
        <tr>
          <td>perubahan alpha</td><td><input type="text" name="calpha" required></td>
        </tr>
        <?php
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
  $calpha = $_POST['calpha'];
  $batasColData = 0;
  $batasColBobot = 0;
  $JejakClus=[];

  foreach ($data as $d) {
    $batasColData=count($d);
    break;
  }
  foreach ($bobot as $b) {
    $batasColBobot = count($b);
    break;
  }?>

  
  <?php
  #ini iterasi yang ditentukan
  for ($per=0; $per<$iterasi; $per++)
  {
      echo "<table border=1px><tr><td colspan=4><b>Iterasi ke-".($per+1)."</b><br/></td></tr>";
      echo "<tr><td colspan=4>Alpha = ".$alpha."<br/></td></tr>";
      #iterasi array data
      for ($rowdata=0; $rowdata<count($data); $rowdata++)
      {
        echo "<tr><td>Data ke-".($rowdata+1)." : </td>";
        $hasildat=0;
        $indexClus=0;
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
          echo "<td >D".($colbobot+1)." = ".$hasil."</td>";
          #memilih hasil jarak neuron terkecil
          if ($hasildat==0)
          {
            $hasildat=$hasil;
            $indexClus=$colbobot+1;
            $JejakClus[$rowdata]=$indexClus;
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
              $indexClus=$colbobot+1;
              $JejakClus[$rowdata]=$indexClus;
              for ($rowbobot=0; $rowbobot<count($bobot); $rowbobot++)
              {
                $bobotmenang[$rowbobot]=$bobot[$rowbobot][$colbobot];
                $ind1[$rowbobot]=$rowbobot;
                $ind2[$rowbobot]=$colbobot;
              }
            }
          }
        }
        echo "</tr>";
        echo "<tr><td colspan=4>Nilai neuron terkecil (terpilih) = ".$hasildat."</td></tr>";
        echo "<tr><td colspan=4>Index cluster bobot (terpilih) = ".$indexClus."</td></tr>";

          #menghitung bobot baru
          $rowdata=$rowdata;
          for ($coldata=0; $coldata<$batasColData; $coldata++)
          {
          	#rumus bobot baru
            $datahitung[$coldata]=$data[$rowdata][$coldata];
            $hasilhitung1[$coldata]= $datahitung[$coldata]-$bobotmenang[$coldata];
            $hasilhitung2[$coldata]= $alpha * $hasilhitung1[$coldata];
          }
          
          for ($rowbobot=0; $rowbobot<count($bobot); $rowbobot++)
          {
            $hasilakhir[$rowbobot] = $bobotmenang[$rowbobot]+$hasilhitung2[$rowbobot];
            #mengubah bobot lama yang terpilih dengan bobot baru
            $bobot[$ind1[$rowbobot]][$ind2[$rowbobot]]=$hasilakhir[$rowbobot];
          }
          echo "<tr><td colspan=4>Bobot Baru :</td></tr>";
          foreach ($bobot as $bot) {
          echo "<tr><td></td>";
          foreach ($bot as $b) {
            ?>
              <td><?php echo $b; ?></td>
            <?php
          }
          echo "</tr>";
          }

      }
      echo "</table><br/>";
      
      #mengubah nilai alpha
      $alpha=$alpha*$calpha;
  }
  ?>
  <table border="1px">
    <tr>
      <td colspan="3">Bobot akhir : </td>
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
  </table><br/>

  <table border="1px">
    <tr>
      <td colspan="3">Index cluster yang diikuti : </td>
    </tr>
    <?php
      foreach ($JejakClus as $jc) {
        echo "<tr>";
          ?>
            <td><?php echo $jc; ?></td>
          <?php
        echo "</tr>";
      }
     ?>
  </table>
  <?php
}
 ?>
</body>
</html>
