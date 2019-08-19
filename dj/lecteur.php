<?php require ('../parametre/security.php'); ?>

<meta charset="utf-8">

  <div class="deck_1">
    <b id="numero_deck">1</b>
    <b id="control">
      <button class="control" id="deck_1_play" onclick="play('deck_1', this)"><img src="img/play_icon.png" width="30"/></button>
      <button class="control" id="deck_stop" onclick="resume('deck_1')"><img src="img/stop_icon.png" width="30"/></button>
    </b>

    <img id="cd_fixe_deck_1" src="img/cd_fixe.gif"/>
    <img id="cd_mobile_deck_1" src="img/cd_mobile.gif" style="opacity:0;"/>
    <span id="deck_1_titre">Aucune musiques</span>
    <div class="deck_1_control">
      <audio id="deck_1" onEnded="resume('deck_1')" onerror="erreur_lecteur('deck_1')">
          <source src="">
      </audio>

      <input type="range" id="deck_1_sliderBar" min="0"  style="width:80%"  step="0.01" value="0" onChange = "move_music(this.value,'deck_1')"><br>
      <span id="deck_1_progressTime">00:00</span>
      <span>/</span>
      <span id="deck_1_timemax"></span>
    </div>
      <input type="range" id="deck_1_sliderBar_vol" min="0" max="1" step="0.01" value="1" onChange = "sound_music(this.value,'deck_1')" onmousemove = "sound_music(this.value,'deck_1')">
  </div>

  <div class="deck_2" >
    <b id="numero_deck">2</b>
    <b id="control">
      <button class="control" id="deck_2_play" onclick="play('deck_2', this)"><img src="img/play_icon.png" width="30"/></button>
      <button class="control" id="deck_stop" onclick="resume('deck_2')"><img src="img/stop_icon.png" width="30"/></button>
    </b>

    <img id="cd_fixe_deck_2" src="img/cd_fixe.gif"/>
    <img id="cd_mobile_deck_2" src="img/cd_mobile.gif" style="opacity:0;"/>
    <span id="deck_2_titre"></span>
    <div class="deck_2_control">
      <audio  id="deck_2" onended="resume('deck_2')" onerror="erreur_lecteur('deck_2')">
          <source src="">
      </audio>
      
      <input type="range" id="deck_2_sliderBar" min="0"  style="width:80%"  step="0.01" value="0" onChange = "move_music(this.value,'deck_2')"><br>
      <span id="deck_2_progressTime">00:00</span>
      <span>/</span>
      <span id="deck_2_timemax"></span>
    </div>
      <input type="range" id="deck_2_sliderBar_vol" min="0" max="1" step="0.01" value="1" onChange = "sound_music(this.value,'deck_2')" onmousemove = "sound_music(this.value,'deck_2')">
  


  </div>

  <div class="deck_3" >
    <b id="numero_deck">3</b>
    <b id="control">
      <button class="control" id="deck_3_play" onclick="play('deck_3', this)"><img src="img/play_icon.png" width="30"/></button>
      <button class="control" id="deck_stop" onclick="resume('deck_3')"><img src="img/stop_icon.png" width="30"/></button>
    </b>

    <img id="cd_fixe_deck_3" src="img/cd_fixe.gif"/>
    <img id="cd_mobile_deck_3" src="img/cd_mobile.gif" style="opacity:0;"/>
    <span id="deck_3_titre"></span>
    <div class="deck_3_control">
      <audio id="deck_3" onended="resume('deck_3')" onerror="erreur_lecteur('deck_3')">
          <source src="">
      </audio>
      
      <input type="range" id="deck_3_sliderBar" min="0"  style="width:80%"  step="0.01" value="0" onChange = "move_music(this.value,'deck_3')"><br>
      <span id="deck_3_progressTime">00:00</span>
      <span>/</span>
      <span id="deck_3_timemax"></span>
    </div>
      <input type="range" id="deck_3_sliderBar_vol" min="0" max="1" step="0.01" value="1" onChange = "sound_music(this.value,'deck_2')" onmousemove = "sound_music(this.value,'deck_2')">
  </div>



  <div class="deck_central" align="center">

    <span id="date_heure" ></span><br id="date_heure">
    <span id="message_titre_folder"></span>
    <span id="message" ></span><br>
    
    <button class="control" id="nb_deck" onclick="nb_deck( this.innerHTML )">1 Deck</button>
    
    <button class="control" id="auto_mix_bp" onclick="lancer_auto_mix()">AutoMix</button>

    <div id="auto_mix_control" style="display:none;">

      <button class="control" id="alea_bp" onclick="lecture_aléatoire()">Aléatoire</button>
      
      <button class="control" id="next_mix" onclick="music_suivante()">NextMix</button>
      
      <button class="control" id="vider_list" onclick="vider_playlist()">vider</button>

    </div>
    
    

  </div>



  <div class="crossfader" align="center">

    <button class="control" id="" onclick="auto_move_crossfader(1)"><img src="img/previous_icon.png" width="30"/></button>
    <span id="crossfader_progress_1">50</span>
    <input type="range" id="crossfader" min="-1" max="1" style="width:20%" step="0.01" value="0" onmousemove="/*move_crossfader(this.value)*/" onChange="/*move_crossfader(this.value)*/">
    <span id="crossfader_progress_2">50</span>
    <button class="control" id="" onclick="auto_move_crossfader(2)"><img src="img/next_icon.png" width="30"/></button>

    <input type="search" id="seach_dj_music" placeholder="Search" onkeyup="seach_dj(this.value)" ></input>
  </div>




      