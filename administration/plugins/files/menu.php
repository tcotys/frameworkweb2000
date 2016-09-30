<section id="files_article">
  <h1>Gestion des fichiers</h2>
  <article>
  <p><a href="#" onclick="showNewFileForm(); return false;" class="button new">new file</a></p>
  <ul>
    <?php
      $filetype2img = array(
        'wma' => 'wma',
        'mp3' => 'mp3',
        'ogg' => 'ogg',
        'aiff' => 'audio-file-3',
        'wav' => 'audio-file-3',
        'aif' => 'audio-file-3',
        'aifc' => 'audio-file-3',
        'flac' => 'audio-file-3',
        'm4a' => 'audio-file-3',
        'ape' => 'audio-file-3',
        'aac' => 'audio-file-3',
        
        'txt' => 'document',
        'css' => 'document',
        'html' => 'document',
        'htm' => 'document',
        'js' => 'document',
        'php' => 'document',
        'dat' => 'document',
        
        'dmg' => 'dmg',
        'zip' => 'zip',
        'rar' => 'rar',
        'exe' => 'exe',
        'dll' => 'dll',
        '7z' => 'file',
        'file' => 'file',
        
        'gif' => 'gif',
        'jpg' => 'jpg',
        'psd' => 'psd',
        'png' => 'png',
        'tiff' => 'image-file',
        'tif' => 'image-file',
        
        'mpg' => 'mpg',
        'mov' => 'mov',
        'avi' => 'avi',
        'flv' => 'flv',
        'mp4' => 'video-file-3',
        'ogv' => 'video-file-3',
        'webm' => 'video-file-3',
        
        'pdf' => 'pdf',
        'ppt' => 'powerpoint-3',
        'odp' => 'powerpoint-3',
        'pptx' => 'powerpoint-3',
        'xls' => 'exel',
        'ods' => 'exel',
        'xlsx' => 'exel',
        'doc' => 'word-3',
        'odt' => 'word-3',
        'docx' => 'word-3'
        );
      $rep4 = $bdd->query('SELECT * FROM '.getTablePrefix().'files ORDER BY id');

      while ($don4 = $rep4->fetch())
      {
        if(array_key_exists ($don4['filetype'], $filetype2img )) {
          $fileImg = $filetype2img[$don4['filetype']];
        }
        else {
          $fileImg = 'file';
        }
        $filetypeImgUrl = '../files/'.$fileImg.'-64.png';
        echo '<li class="has_mini">
          <img alt="'.$don4['filetype'].'" src="'.$filetypeImgUrl.'" />
          <span class="img_name" >'.$don4['surname'].'</span>
            <a class="button info" href="#" onclick="editFileInfo('.$don4['id'].', \''.$don4['surname'].'\', \''.$don4['filename'].'\');return false;">infos</a>
            <a class="button download" href="../download.php?file='.$don4['id'].'&download=1">download</a>
            <a class="button delete" href="#" onclick="deleteFile('.$don4['id'].', \''.$don4['surname'].'\');return false;">delete</a>
            <span class="filenamePreview"> '.$don4['filename'].' </span></li>';
      }
      $rep4->closeCursor();
    ?>
  </ul>
  <p><a href="#" onclick="showNewFileForm(); return false;" class="button new">new file</a></p>
  <article>
</section>