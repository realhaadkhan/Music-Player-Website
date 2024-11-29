const songs = [];
document.addEventListener(`DOMContentLoaded`, () => {
  for (let key in window.jsArray) {
    if (window.jsArray.hasOwnProperty(key)) {
      songs.push(window.jsArray[key]);
    }
  }

  Array.from(document.getElementsByClassName('perSong')).forEach((e, i) => {
    e.getElementsByTagName('img')[0].src = songs[i].poster;
    e.getElementsByTagName('h5')[0].innerHTML = songs[i].songName;
    e.getElementsByTagName('h6')[0].innerHTML = songs[i].songArtist;
  });
  /*********************Search Data Start********************/
  let searchResults = document.getElementsByClassName('searchResults')[0];
  songs.forEach(element => {
    const { id, songName, songArtist, poster } = element;
    let card = document.createElement('a');
    card.classList.add('card');
    card.innerHTML = `<img src="${poster}" alt="">
                          <div class="content">
                              <h5>${songName}<br></h5>
                              <h6 class="artist">${songArtist}</h6>
                          </div>`;
    card.href = "#" + id;
    searchResults.appendChild(card);
  });
  let input = document.getElementById('searchdisp');
  input.addEventListener('keyup', () => {
    let inputValue = input.value.toUpperCase();
    let items = searchResults.getElementsByTagName('a');
    for (let index = 0; index < items.length; index++) {
      let as = items[index].getElementsByClassName('content')[0];
      let textValue = as.textContent || as.innerHTML;
      if (textValue.toUpperCase().indexOf(inputValue) > -1) {
        items[index].style.display = "flex";
        console.log();
      } else {
        items[index].style.display = "none";
      }
      if (input.value == 0) {
        searchResults.style.display = "none";
      } else {
        searchResults.style.display = "";
      }

    }
  });
  /*********************Search Data End********************/
  /*********************playListDataStarts********************/
  let mainPlayList = document.getElementsByClassName('menu_songs')[0];
  songs.forEach(element => {
    const { id, songName, songArtist, poster } = element;
    let songsCard = document.createElement('li');
    songsCard.classList.add('perSong');
    songsCard.innerHTML = `<span class="noFact">${id}</span>
                          <img src="${poster}" alt="">
                          <div class="gDisp">
                          <h5>${songName}<br></h5>
                          <h6 class="artist">${songArtist}</h6>
                          </div>
                          <i class="bi playListPlay bi-play-circle-fill" id="${id}"></i>`;
    mainPlayList.appendChild(songsCard);
  });
  /*********************playListDataEnds********************/
  /*********************Remote********************/
  let music = new Audio();
  let masterPlay = document.getElementById('masterPlay');
  const outline = document.getElementById('outline');
  const visualizer = document.querySelector('.visualizer');

  masterPlay.addEventListener('click', () => {

    if (music.paused || music.currentTime <= 0) {

      if (!this.ctx) {
        audioVisualizer(music);
      }
      music.play();



      masterPlay.classList.remove('bi-play-fill');
      masterPlay.classList.add('bi-pause-fill');
      outline.classList.add('plays');
    }
    else {

      music.pause();
      masterPlay.classList.remove('bi-pause-fill');
      masterPlay.classList.add('bi-play-fill');
      outline.classList.remove('plays');


    }
  });



  /*********************Decide later********************/
  let active = undefined
  let tabs = document.querySelectorAll(`span.onHover`)
  tabs.forEach((tab) => {
    tab.addEventListener(`click`, () => {
      if (active) active.classList.remove(`active`)
      tab.classList.add(`active`)
      active = tab
    })
  })
  /*********************Timing********************/
  var myDate = new Date();
  var hrs = myDate.getHours();
  var greet;
  var smp = document.getElementById('wish')
  if (hrs < 12)
    greet = 'Good Morning';
  else if (hrs >= 12 && hrs <= 17)
    greet = 'Good Afternoon';
  else if (hrs >= 17 && hrs <= 24)
    greet = 'Good Evening';

  smp.innerHTML = greet;
  /*********************Popular Songs Move back and foward********************/
  // for scrolling the musics
  let popSongLeft = document.getElementById('popSongLeft');
  let popSongRight = document.getElementById('popSongRight');
  let songList = document.getElementsByClassName('songList')[0];

  popSongRight.addEventListener('click', () => {
    songList.scrollLeft += 330;
  })
  popSongLeft.addEventListener('click', () => {
    songList.scrollLeft -= 330;
  })

  /*********************Popular Songs Move back and foward********************/
  // for scrolling the musics
  let popArtistLeft = document.getElementById('popArtistLeft');
  let popArtistRight = document.getElementById('popArtistRight');
  let item = document.getElementsByClassName('item')[0];

  popArtistRight.addEventListener('click', () => {
    item.scrollLeft += 330;
  })
  popArtistLeft.addEventListener('click', () => {
    item.scrollLeft -= 330;
  })
  /*********************Indexing BackgroundColor(Declaration)********************/
  // change the background color of current music label in list
  const makeAllBackground = () => {
    Array.from(document.getElementsByClassName('perSong')).forEach((el) => {
      el.style.background = 'rgba(128, 128, 128, 0)';
    })
  }
  /*********************Indexing plays(Declaration)********************/
  // make the icons play whose music is not getting played
  const makeAllplays = () => {
    Array.from(document.getElementsByClassName('playListPlay')).forEach((el) => {
      el.classList.add('bi-play-circle-fill');
      el.classList.remove('bi-pause-circle-fill');
    })
  }
  /*********************Indexing songs********************/
  let index = 0;
  let posterPlay = document.getElementById('posterPlay');
  let title = document.getElementById('title');
  let artist = document.getElementById('artist');
  Array.from(document.getElementsByClassName('playListPlay')).forEach((e) => {
    e.addEventListener('click', (el) => {
      if (!this.ctx) {
        audioVisualizer(music);
      }
      index = el.target.id;
      music.src = `audio/${index}.mp3`;
      posterPlay.src = `authorPFPs/${index}.jpg`;
      music.play();
      masterPlay.classList.remove('bi-play-fill');
      masterPlay.classList.add('bi-pause-fill');
      outline.classList.add('plays');
      /*********************Indexing songsTitle/songArtist********************/
      let songTitles = songs.filter((els) => {
        return els.id == index;
      });
      let songArtists = songs.filter((els1) => {
        return els1.id == index;
      })
      songTitles.forEach(elss => {
        let { songName } = elss;
        title.innerHTML = songName;
      })
      songArtists.forEach(elss1 => {
        let { songArtist } = elss1;
        artist.innerHTML = songArtist;
      })
      /*********************Indexing BackgroundColor********************/
      makeAllBackground();
      Array.from(document.getElementsByClassName('perSong'))[index - 1].style.background = 'rgba(128, 128, 128, 0.251)';
      /*********************Indexing plays********************/
      makeAllplays();
      Array.from(document.getElementsByClassName('perSong'))[index - 1].style.background = 'rgba(128, 128, 128, 0.251)';
      el.target.classList.remove('bi-play-circle-fill');
      el.target.classList.add('bi-pause-circle-fill');
    })
  })
  /*********************updateGUI Function********************/
  /* this function is created for conviniency to call it in other main functions, 
  this will simply update everything in main remote like picture, name, author label, etc*/
  const updateGUI = () => {
    music.src = `audio/${index}.mp3`;
    posterPlay.src = `authorPFPs/${index}.jpg`;
    music.play();
    masterPlay.classList.remove('bi-play-fill');
    masterPlay.classList.add('bi-pause-fill');
    outline.classList.add('plays');



    let songTitles = songs.filter((els) => {
      return els.id == index;
    });
    let songArtists = songs.filter((els1) => {
      return els1.id == index;
    })
    songTitles.forEach(elss => {
      let { songName } = elss;
      title.innerHTML = songName;
    })
    songArtists.forEach(elss1 => {
      let { songArtist } = elss1;
      artist.innerHTML = songArtist;
    })



    makeAllBackground();
    Array.from(document.getElementsByClassName('perSong'))[index - 1].style.background = 'rgba(128, 128, 128, 0.251)';
    makeAllplays();
    Array.from(document.getElementsByClassName('playListPlay'))[index - 1].classList.remove('bi-play-circle-fill');
    Array.from(document.getElementsByClassName('playListPlay'))[index - 1].classList.add('bi-pause-circle-fill');
  }
  /*********************Seek-Slider********************/
  let seek = document.getElementById('seekSlider');
  let currentStart = document.getElementById('current-time');
  let currentEnd = document.getElementById('total-duration');
  music.addEventListener('timeupdate', () => {
    let music_curr = music.currentTime;
    let min1 = Math.floor(music_curr / 60);
    let sec1 = Math.floor(music_curr % 60);
    if (sec1 < 10) {
      sec1 = `0${sec1}`;
    }
    currentStart.innerText = `${min1}:${sec1}`;


    let music_dur = music.duration;
    let min2 = Math.floor(music_dur / 60);
    let sec2 = Math.floor(music_dur % 60);
    if (sec2 < 10) {
      sec2 = `0${sec2}`;
    }
    currentEnd.innerText = `${min2}:${sec2}`;

    let progressBar = parseInt((music_curr / music_dur) * 100);
    seek.value = progressBar;
    let color = 'linear-gradient(90deg, rgb(255, 255, 255)' + seek.value + '%, rgb(255, 255, 255, 0.5)' + seek.value + '%)';
    seek.style.background = color;
  })
  seek.addEventListener('change', () => {
    music.currentTime = seek.value * music.duration / 100;
    let color = 'linear-gradient(90deg, rgb(255, 255, 255)' + seek.value + '%, rgb(255, 255, 255, 0.5)' + seek.value + '%)';
    seek.style.background = color;
  })
  /*********************rPrev/Next Button********************/
  let back = document.getElementById('back');
  let next = document.getElementById('next');
  back.addEventListener('click', () => {
    index -= 1;
    if (index < 1) {
      index = Array.from(document.getElementsByClassName('perSong')).length;
    }
    updateGUI();
  })


  next.addEventListener('click', () => {
    index++;
    if (index > Array.from(document.getElementsByClassName('perSong')).length) {
      index = 1;
    }
    updateGUI();
  })
  /*********************AudioVisualizer********************/
  function audioVisualizer(music) {
    if (this.ctx == undefined) {
      this.ctx = new AudioContext();
    }

    const source = this.ctx.createMediaElementSource(music);
    const analyser = this.ctx.createAnalyser();
    source.connect(analyser);
    analyser.connect(this.ctx.destination);
    analyser.fftSize = 32;
    const bufferLength = analyser.frequencyBinCount;
    const dataArray = new Uint8Array(bufferLength);
    let elements = [];
    for (let i = 0; i < bufferLength; i++) {
      const element = document.createElement('span');
      element.classList.add('element');
      elements.push(element);
      visualizer.appendChild(element);
    }
    const clamp = (num, min, max) => {
      if (num >= max) return max;
      if (num <= min) return min;
      return num;
    }
    const update = () => {
      analyser.getByteFrequencyData(dataArray);
      for (let i = 0; i < bufferLength; i++) {
        let item = dataArray[i];
        item = item > 150 ? item / 1.5 : item * 1.5;
        elements[i].style.transform = `rotateZ(${i * (360 / bufferLength)}deg) translate(-50%, ${clamp(item, 25, 37.5)}px)`;
      }
      requestAnimationFrame(update);
    };

    update();
  }
  /*********************Shuffle/repeat********************/
  let shuffle = document.getElementsByClassName('shuffle')[0];
  let a = shuffle.getElementsByTagName('h6')[0];
  shuffle.addEventListener('click', () => {
    switch (a.innerHTML) {
      case "next":
        shuffle.classList.add('bi-repeat');
        shuffle.classList.remove('bi-music-note-beamed');
        shuffle.classList.remove('bi-shuffle');
        a.innerHTML = 'repeat';
        break;
      case "repeat":
        shuffle.classList.remove('bi-repeat');
        shuffle.classList.remove('bi-music-note-beamed');
        shuffle.classList.add('bi-shuffle');
        a.innerHTML = 'random';
        break;
      case "random":
        shuffle.classList.remove('bi-shuffle');
        shuffle.classList.remove('bi-repeat');
        shuffle.classList.add('bi-music-note-beamed');
        a.innerHTML = 'next';
        break;
    }
  })
  music.addEventListener("ended", () => {
    let b = shuffle.getElementsByTagName('h6')[0];
    switch (b.innerHTML) {
      case "next":
        nextMusic();
        break;
      case "repeat":
        repeatMusic();
        break;
      case "random":
        randomMusic();
        break;
    }
  })
  const nextMusic = () => {
    // this func will play music consecutively
    if (index == songs.length) {
      index = 1;
    }
    else {
      index++;
    }
    updateGUI();
  }
  const repeatMusic = () => {
    // this func will play one music repetively
    index;
    updateGUI();
  }
  const randomMusic = () => {
    // this func will play music randomly
    if (index == songs.length) {
      index = 1;
    }
    else {
      index = Math.floor((Math.random() * songs.length) + 1);
    }
    updateGUI();
  }


  const heartIcon = document.querySelector(".like-button .heart-icon");
  const likesAmountLabel = document.querySelector(".like-button .likes-amount");

  let likesAmount = 7;

  heartIcon.addEventListener("click", () => {
    heartIcon.classList.toggle("liked");
    if (heartIcon.classList.contains("liked")) {
      likesAmount++;
    } else {
      likesAmount--;
    }

    likesAmountLabel.innerHTML = likesAmount;
  });

})