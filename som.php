<?php
  $data = array(
        array(1, 1),
        array(4, 1),
        array(1, 2),
        array(3, 4),
        array(5, 4));
  $bobot = array(
        array(2, 2, 2),
        array(2, 3, 5));
  $alpha = 0.5;
  $iterasi=5;
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
      $alpha=$alpha*0.6;
  }

  echo var_dump ($bobot);
  //echo count($data);

 ?>
