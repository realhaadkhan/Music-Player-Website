<?php
include('dbConnect.php');
session_start();
$user_id = $_SESSION['user_id'];
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CharliePuth_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script type="text/javascript" src="app.js"></script> -->
    <title>MicroProject</title>
</head>

<body>
    <script>
        document.addEventListener(`DOMContentLoaded`, () => {
            let allSongs = [];
            <?php
            $sql = "SELECT * FROM musics_db WHERE songArtist LIKE '%Charlie Puth%'";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $music_id = $row['id'];
                    $songName = $row['songName'];
                    $songArtist = $row['songArtist'];
                    $poster = $row['poster'];
                    $ratings = $row['ratings'];
                    $res = mysqli_query($con, "SELECT * FROM music_status WHERE music_id = $music_id AND user_id = $user_id");
                    if (mysqli_num_rows($res) == 1) {
                        $status = "liked";
                    } else {
                        $status = "unliked";
                    }
                    ?>
                    allSongs.push(
                        {
                            id: <?php echo $music_id ?>,
                            songName: "<?php echo $songName ?>",
                            songArtist: "<?php echo $songArtist ?>",
                            poster: "<?php echo $poster ?>",
                            status: "<?php echo $status ?>",
                            ratings: <?php echo $ratings ?>
                        }
                    );

                    <?php
                }
            }

            ?>
            let popSongs = [];
            <?php
            $popsql = "SELECT * FROM musics_db WHERE ratings > 3 AND songArtist LIKE '%Charlie Puth%' ORDER BY ratings DESC";
            $popresult = mysqli_query($con, $popsql);
            if (mysqli_num_rows($popresult) > 0) {
                while ($prow = mysqli_fetch_assoc($popresult)) {
                    $pmusic_id = $prow['id'];
                    $psongName = $prow['songName'];
                    $psongArtist = $prow['songArtist'];
                    $pposter = $prow['poster'];
                    $pratings = $prow['ratings'];
                    $pres = mysqli_query($con, "SELECT * FROM music_status WHERE music_id = $pmusic_id AND user_id = $user_id");
                    if (mysqli_num_rows($pres) == 1) {
                        $pstatus = "liked";
                    } else {
                        $pstatus = "unliked";
                    }
                    ?>
                    popSongs.push(
                        {
                            id: <?php echo $pmusic_id ?>,
                            songName: "<?php echo $psongName ?>",
                            songArtist: "<?php echo $psongArtist ?>",
                            poster: "<?php echo $pposter ?>",
                            status: "<?php echo $pstatus ?>",
                            ratings: <?php echo $pratings ?>
                        }
                    );

                    <?php
                }
            }

            ?>
            console.log(allSongs);
            console.log(popSongs);
            /*********************Search Data Start********************/
            let searchResults = document.getElementsByClassName('searchResults')[0];
            allSongs.forEach(element => {
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
            // Get all the cards
            const cards = document.querySelectorAll('.card');

            // Add a click event listener to each card
            cards.forEach(card => {
                card.addEventListener('click', function (event) {
                    // Prevent the default action of the link
                    event.preventDefault();

                    // Get the id of the card from the href attribute
                    const iden = this.getAttribute('href').substr(1);

                    // Get the element with the corresponding id
                    const elementing = document.getElementById(iden);

                    // Scroll to the element using smooth scrolling
                    elementing.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            /*********************Search Data End********************/
            /*********************playListDataStarts********************/
            let mainPlayList = document.getElementsByClassName('menu_songs')[0];
            allSongs.forEach(element => {
                const { id, songName, songArtist, poster } = element;
                let songsCard = document.createElement('li');
                songsCard.classList.add('perSong');

                songsCard.innerHTML = `<span class="noFact">${id}</span>
                                                          <img src="${poster}" alt="">
                                                          <div class="gDisp">
                                                          <h5>${songName}<br></h5>
                                                          <h6 class="artist">${songArtist}</h6>
                                                          </div>
                                                          <i class="bi playListPlay bi-play-circle-fill" id="${id}" name="playListSongs"></i>`;
                mainPlayList.appendChild(songsCard);



            });
            /*********************playListDataEnds********************/
            /*********************popSongsDataStarts********************/
            let popPlayList = document.getElementsByClassName('songList')[0];
            popSongs.forEach(element => {
                const { id, songName, songArtist, poster } = element;
                let popSongsCard = document.createElement('li');
                popSongsCard.classList.add('eachSong');

                popSongsCard.innerHTML = `<div class="img_play">
                                          <img src="${poster}" alt="">
                                          <i class="bi playListPlay bi-play-circle-fill" id="${id}" name="popularSongs"></i>
                                          </div>
                                          <div class="gDisp">
                                          <h5>${songName}<br></h5>
                                          <h6 class="artist">${songArtist}</h6>
                                          </div>`;
                popPlayList.appendChild(popSongsCard);



            });
            /*********************popSongstDataEnds********************/
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

            // /*********************Popular Songs Move back and foward********************/
            // // for scrolling the musics
            // let popArtistLeft = document.getElementById('popArtistLeft');
            // let popArtistRight = document.getElementById('popArtistRight');
            // let item = document.getElementsByClassName('item')[0];

            // popArtistRight.addEventListener('click', () => {
            //     item.scrollLeft += 330;
            // })
            // popArtistLeft.addEventListener('click', () => {
            //     item.scrollLeft -= 330;
            // })
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
            let lastPlayed;
            let index;
            let music_id;
            let state;
            let likesAmount;
            let posterPlay = document.getElementById('posterPlay');
            let title = document.getElementById('title');
            let artist = document.getElementById('artist');
            let downBtn = document.getElementById('downloadMusic');
            let heartIcon = document.querySelector(".like-button .heart-icon");
            let likeLabel = document.querySelector(".likeCount");
            let popSongsClass = 'eachSong';
            let allSongsClass = 'perSong';
            Array.from(document.getElementsByClassName('playListPlay')).forEach((e) => {
                e.addEventListener('click', playControl);
            })
            /*********************playControl********************/
            let clickedList;
            function playControl(el) {
                clickedList = el.target.getAttribute('name');
                if (clickedList === 'popularSongs') {
                    indexSongs(popSongs, el, popSongsClass);
                } else if (clickedList === 'playListSongs') {
                    indexSongs(allSongs, el, allSongsClass);
                }
            }
            /*********************Slike/dislike********************/
            let user_id = <?php echo $user_id; ?>;
            heartIcon.addEventListener("click", () => {
                if (state === 'liked') {
                    heartIcon.classList.remove('liked');
                    heartIcon.classList.add('unliked');
                    state = 'unliked';
                    likesAmount--;
                    likeLabel.innerHTML = likesAmount;
                    const ind = allSongs.findIndex(song => parseInt(song.id) === parseInt(music_id));
                    allSongs[ind].status = 'unliked';
                    allSongs[ind].ratings--;
                    const inde = popSongs.findIndex(song => parseInt(song.id) === parseInt(music_id));
                    if (inde != -1) {
                        popSongs[inde].status = 'unliked';
                        popSongs[inde].ratings--;
                    }
                    let xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText);
                        }
                    };
                    xhttp.open("POST", "ratings.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    let data = "music_id=" + music_id + "&user_id=" + user_id;
                    xhttp.send(data);
                }
                else if (state === 'unliked') {
                    heartIcon.classList.remove('unliked');
                    heartIcon.classList.add('liked');
                    state = 'liked';
                    likesAmount++;
                    likeLabel.innerHTML = likesAmount;
                    const ind = allSongs.findIndex(song => parseInt(song.id) === parseInt(music_id));
                    allSongs[ind].status = 'liked';
                    allSongs[ind].ratings++;
                    const inde = popSongs.findIndex(song => parseInt(song.id) === parseInt(music_id));
                    if (inde != -1) {
                        popSongs[inde].status = 'liked';
                        popSongs[inde].ratings++;
                    }
                    let xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText);
                        }
                    };
                    xhttp.open("POST", "ratings.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    let data = "music_id=" + music_id + "&user_id=" + user_id;
                    xhttp.send(data);
                }
            })
            /*********************updateGUI Function********************/
            /* this function is created for conviniency to call it in other main functions, 
            this will simply update everything in main remote like picture, name, author label, etc*/
            const updateGUI = (songs, songClass) => {
                music.src = `audio/${music_id}.mp3`;
                posterPlay.src = `authorPFPs/${music_id}.jpg`;
                music.play();
                masterPlay.classList.remove('bi-play-fill');
                masterPlay.classList.add('bi-pause-fill');
                outline.classList.add('plays');
                downBtn.href = `audio/${music_id}.mp3`
                /*********************Indexing songsTitle/songArtist********************/
                let songTitles = songs.filter((els) => {
                    return els.id == music_id;
                });
                let songArtists = songs.filter((els1) => {
                    return els1.id == music_id;
                })
                songTitles.forEach(elss => {
                    let { songName } = elss;
                    title.innerHTML = songName;
                    downBtn.setAttribute('download', songName);
                })
                songArtists.forEach(elss1 => {
                    let { songArtist } = elss1;
                    artist.innerHTML = songArtist;
                })
                let songRatings = songs.filter((els1) => {
                    return els1.id == music_id;
                })
                let songStatus = songs.filter((els1) => {
                    return els1.id == music_id;
                })
                songRatings.forEach(elss => {
                    let { ratings } = elss;
                    likeLabel.innerHTML = ratings;
                    likesAmount = elss.ratings;
                })
                songStatus.forEach(elss1 => {
                    let { status } = elss1;
                    state = elss1.status;
                    // let user_id = <?php echo $user_id; ?>;
                    if (status === 'liked') {
                        heartIcon.classList.remove('unliked');
                        heartIcon.classList.add('liked');
                    }
                    if (status === 'unliked') {
                        heartIcon.classList.remove('liked');
                        heartIcon.classList.add('unliked');
                    }
                })
                if (songClass === 'perSong') {
                    // Array.from(document.getElementsByClassName('eachSong')).forEach((el) => {
                    //     el.style.background = 'rgba(128, 128, 128, 0)';
                    // })
                    Array.from(document.getElementsByClassName(songClass)).forEach((el) => {
                        el.style.background = 'rgba(128, 128, 128, 0)';
                    })
                    makeAllplays();
                    Array.from(document.getElementsByClassName(songClass))[index].style.background = 'rgba(128, 128, 128, 0.251)';
                    Array.from(document.getElementsByName('playListSongs'))[index].classList.remove('bi-play-circle-fill');
                    Array.from(document.getElementsByName('playListSongs'))[index].classList.add('bi-pause-circle-fill');
                }
                if (songClass === 'eachSong') {
                    // Array.from(document.getElementsByClassName('perSong')).forEach((el) => {
                    //     el.style.background = 'rgba(128, 128, 128, 0)';
                    // })
                    Array.from(document.getElementsByClassName(songClass)).forEach((el) => {
                        el.style.background = 'rgba(128, 128, 128, 0)';
                    })
                    Array.from(document.getElementsByClassName(songClass))[index].style.background = 'rgba(128, 128, 128, 0.251)';
                    makeAllplays();
                    Array.from(document.getElementsByName('popularSongs'))[index].classList.remove('bi-play-circle-fill');
                    Array.from(document.getElementsByName('popularSongs'))[index].classList.add('bi-pause-circle-fill');
                }
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
                // let shadow = '0 0 1em rgb(255, 255, 255), 0 0 0.2em rgb(255, 255, 255) ' + seek.value + '%, 0 0 0em rgb(255, 255, 255), 0 0 0.0em rgb(255, 255, 255) ' + seek.value + '%';
                let color = 'linear-gradient(90deg, rgb(255, 255, 255)' + seek.value + '%, rgb(255, 255, 255, 0.5)' + seek.value + '%)';
                seek.style.background = color;
                // seek.style.boxShadow = shadow;
            })
            seek.addEventListener('change', () => {
                music.currentTime = seek.value * music.duration / 100;
                // let shadow = '0 0 1em rgb(255, 255, 255), 0 0 0.2em rgb(255, 255, 255) ' + seek.value + '%, 0 0 0em rgb(255, 255, 255), 0 0 0.0em rgb(255, 255, 255) ' + seek.value + '%';
                let color = 'linear-gradient(90deg, rgb(255, 255, 255)' + seek.value + '%, rgb(255, 255, 255, 0.5)' + seek.value + '%)';
                seek.style.background = color;
                // seek.style.boxShadow = shadow;
            })
            /*********************rPrev/Next Button********************/
            let back = document.getElementById('back');
            let next = document.getElementById('next');
            back.addEventListener('click', () => {
                if (clickedList === 'playListSongs') {
                    index -= 1;
                    if (index < 0) {
                        index = Array.from(document.getElementsByClassName('perSong')).length - 1;
                        music_id = allSongs[allSongs.length - 1]['id'];
                    }
                    else {
                        music_id = allSongs[index]['id'];
                    }
                    updateGUI(allSongs, allSongsClass);
                }
                else if (clickedList === 'popularSongs') {
                    index -= 1;
                    if (index < 0) {
                        index = Array.from(document.getElementsByClassName('eachSong')).length - 1;
                        music_id = popSongs[popSongs.length - 1]['id'];
                    }
                    else {
                        music_id = popSongs[index]['id'];
                    }
                    updateGUI(popSongs, popSongsClass);
                }
            })

            next.addEventListener('click', () => {
                if (clickedList === 'playListSongs') {
                    if (index === allSongs.length - 1) {
                        index = 0;
                        music_id = allSongs[index]['id'];
                    }
                    else if (index < allSongs.length - 1) {
                        index++;
                        music_id = allSongs[index]['id'];
                    }
                    updateGUI(allSongs, allSongsClass);
                }
                else if (clickedList === 'popularSongs') {
                    if (index === popSongs.length - 1) {
                        index = 0;
                        music_id = popSongs[index]['id'];
                    }
                    else if (index < popSongs.length - 1) {
                        index++;
                        music_id = popSongs[index]['id'];
                    }
                    updateGUI(popSongs, popSongsClass);
                }
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
                if (clickedList === 'playListSongs') {
                    if (index === allSongs.length - 1) {
                        index = 0;
                        music_id = allSongs[index]['id'];
                    }
                    else if (index < allSongs.length - 1) {
                        index++;
                        music_id = allSongs[index]['id'];
                    }
                    updateGUI(allSongs, allSongsClass);
                }
                else if (clickedList === 'popularSongs') {
                    if (index === popSongs.length - 1) {
                        index = 0;
                        music_id = popSongs[index]['id'];
                    }
                    else if (index < popSongs.length - 1) {
                        index++;
                        music_id = popSongs[index]['id'];
                    }
                    updateGUI(popSongs, popSongsClass);
                }
            }
            const repeatMusic = () => {
                // this func will play one music repetively
                if (clickedList === 'playListSongs') {
                    index;
                    music_id;
                    updateGUI(allSongs, allSongsClass);
                }
                else if (clickedList === 'popularSongs') {
                    index;
                    music_id;
                    updateGUI(popSongs, popSongsClass);
                }
            }
            const randomMusic = () => {
                // this func will play music randomly
                if (clickedList === 'playListSongs') {
                    if (index === allSongs.length - 1) {
                        index = 0;
                        music_id = allSongs[index]['id'];
                    }
                    else if (index < allSongs.length - 1) {
                        index = Math.floor((Math.random() * allSongs.length));
                        console.log(index);
                        music_id = allSongs[index]['id'];
                    }
                    updateGUI(allSongs, allSongsClass);
                }
                else if (clickedList === 'popularSongs') {
                    if (index === popSongs.length - 1) {
                        index = 0;
                        music_id = popSongs[index]['id'];
                    }
                    else if (index < popSongs.length - 1) {
                        index = Math.floor((Math.random() * popSongs.length));
                        console.log(index);
                        music_id = popSongs[index]['id'];
                    }
                    updateGUI(popSongs, popSongsClass);
                }
            }
            const indexSongs = (songs, el, songClass) => {
                if (!this.ctx) {
                    audioVisualizer(music);
                }
                index = songs.findIndex(song => song.id === parseInt(el.target.id));
                music_id = el.target.id;
                music.src = `audio/${music_id}.mp3`;
                posterPlay.src = `authorPFPs/${music_id}.jpg`;
                music.play();
                masterPlay.classList.remove('bi-play-fill');
                masterPlay.classList.add('bi-pause-fill');
                outline.classList.add('plays');
                downBtn.href = `audio/${music_id}.mp3`;
                /*********************Indexing songsTitle/songArtist********************/
                let songTitles = songs.filter((els) => {
                    return els.id == music_id;
                });
                let songArtists = songs.filter((els1) => {
                    return els1.id == music_id;
                })
                songTitles.forEach(elss => {
                    let { songName } = elss;
                    title.innerHTML = songName;
                    downBtn.setAttribute('download', songName);
                })
                songArtists.forEach(elss1 => {
                    let { songArtist } = elss1;
                    artist.innerHTML = songArtist;
                })
                let songRatings = songs.filter((els1) => {
                    return els1.id == music_id;
                })
                let songStatus = songs.filter((els1) => {
                    return els1.id == music_id;
                })
                songRatings.forEach(elss => {
                    let { ratings } = elss;
                    likeLabel.innerHTML = ratings;
                    likesAmount = elss.ratings;
                })
                songStatus.forEach(elss1 => {
                    let { status } = elss1;
                    state = elss1.status;
                    // let user_id = <?php echo $user_id; ?>;
                    if (status === 'liked') {
                        heartIcon.classList.remove('unliked');
                        heartIcon.classList.add('liked');
                    }
                    if (status === 'unliked') {
                        heartIcon.classList.remove('liked');
                        heartIcon.classList.add('unliked');
                    }
                })
                if (songClass === 'perSong') {
                    Array.from(document.getElementsByClassName('eachSong')).forEach((el) => {
                        el.style.background = 'rgba(128, 128, 128, 0)';
                    })
                    Array.from(document.getElementsByClassName(songClass)).forEach((el) => {
                        el.style.background = 'rgba(128, 128, 128, 0)';
                    })
                    makeAllplays();
                    Array.from(document.getElementsByClassName(songClass))[index].style.background = 'rgba(128, 128, 128, 0.251)';
                    el.target.classList.remove('bi-play-circle-fill');
                    el.target.classList.add('bi-pause-circle-fill');
                }
                if (songClass === 'eachSong') {
                    Array.from(document.getElementsByClassName('perSong')).forEach((el) => {
                        el.style.background = 'rgba(128, 128, 128, 0)';
                    })
                    Array.from(document.getElementsByClassName(songClass)).forEach((el) => {
                        el.style.background = 'rgba(128, 128, 128, 0)';
                    })
                    Array.from(document.getElementsByClassName(songClass))[index].style.background = 'rgba(128, 128, 128, 0.251)';
                    makeAllplays();
                    el.target.classList.remove('bi-play-circle-fill');
                    el.target.classList.add('bi-pause-circle-fill');
                }
            }
            let pfDropDown = document.getElementById('profileDropDown');
            let pfClass = document.getElementById('pfdrp');
            pfDropDown.addEventListener('click', () => {
                pfClass.classList.toggle("open-dropDown");
            })
            document.addEventListener('click', (event) => {
                // Check if the click target is inside the drop-down element
                if (!pfClass.contains(event.target) && !pfDropDown.contains(event.target)) {
                    // If not, remove the open-dropDown class to close the drop-down
                    pfClass.classList.remove("open-dropDown");
                }
            });
        })
    </script>
    <div class="play">
        <div class="like-button">
            <div class="heart-bg">
                <div class="heart-icon unliked"></div>
            </div>
        </div>
        <div class="likeCount"></div>
        <div class="plays" id="outline"></div>
        <div class="wrapper">
            <div class="box">
                <div class="visualizer"></div>
            </div>
            <div class="details">
                <div class="track-art">
                    <img src="" alt="" class="posterPlay" id="posterPlay">
                </div>
                <div class="track-name" id="title">Track Name</div>
                <div class="track-artist" id="artist">Track Artist</div>
            </div>
            <div class="slider-container">
                <div class="current-time" id="current-time">00:00</div>
                <input type="range" min="0" max="100" value="0" class="seek-slider" id='seekSlider'>
                <div class="total-duration" id="total-duration">00:00</div>
            </div>
            <div class="buttons">
                <div class="dload">
                    <a href="" id="downloadMusic" download><i class="bi bi-download"></i></a>
                </div>
                <div class="prev-track">
                    <i class="bi bi-skip-start-fill" id="back"></i>
                </div>
                <div class="playpause-track">
                    <i class="bi bi-play-fill" id="masterPlay"></i>
                </div>
                <div class="next-track">
                    <i class="bi bi-skip-end-fill" id="next"></i>
                </div>
                <div class="repeat-track">
                    <i class="bi shuffle bi-music-note-beamed">
                        <h6>next</h6>
                    </i>
                </div>
            </div>
        </div>

    </div>
    <header>
        <div class="menu">
            <h1 id="wish"></h1>
            <div class="menu_tab">
                <h4><span class="actClass">Playlist</span>
                    <span class="onHover">Last Listening</span>
                    <span class="onHover">Recommended</span>
                </h4>
            </div>
            <div class="menu_songs">
                <!-- <li class="perSong">
                    <span>01</span>
                    <img src="img/1.jpg" alt="">
                    <div class="gDisp">
                        <h5>Willow<br></h5>
                        <h6 class="artist">Taylor Swift</h6>
                    </div>
                    <i class="bi playListPlay bi-play-circle-fill" id="1"></i>
                </li> -->
            </div>
        </div>
        <div class="song">
            <nav>
                <ul>
                    <li><a href="index.php">DISCOVER</a></li><i class="bi bi-chevron-right"></i>
                    <li>Charlie Puth <span></span></li>
                </ul>
                <div class="search">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search Music..." id="searchdisp">
                    <div class="searchResults">
                        <!-- <a href="" class="card">
                            <img src="img/1.jpg" alt="">
                            <div class="content">
                                <h5>Willow<br></h5>
                                <h6 class="artist">Taylor Swift</h6>
                            </div>
                        </a> -->
                    </div>
                </div>
                <div class="profile-dropDown">
                    <div class="user" id="profileDropDown">
                        <i class="bi bi-dot"></i>
                        <?php
                        $select = mysqli_query($con, "SELECT * FROM `userdetails` WHERE id = '$user_id'");
                        if (mysqli_num_rows($select) > 0) {
                            $fetch = mysqli_fetch_assoc($select);
                        }
                        echo '<img src="userPFPs/' . $fetch['pfp'] . '">';
                        ?>
                    </div>
                    <div class="profile-dropDown-List" id="pfdrp">
                        <h4>
                            <div class="use">
                                <?php echo '<img src="userPFPs/' . $fetch['pfp'] . '">';
                                ?>
                            </div>
                            <div class="dtl"></div>
                            <?php echo $fetch['username']; ?>
                            <div>
                                <?php echo $fetch['email']; ?>
                            </div>
                        </h4>
                        <hr />
                        <ul>
                            <li class="profile-dropDown-listItem">
                                <a href="login.php">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                <h1>Charlie Puth - Left and Right</h1>
                <p>Ever since the d-day y-you went away (No, I don't know how)<br>
                    How to erase your body from out my brain (Whatcha gon' do now?)<br>
                    Maybe I should just focus on me instead (But all I think about)<br>
                    Are the nights we were tangled up in your bed
                </p>
                <div class="buttons">
                    <button>Play</button>
                    <button>Follow</button>
                </div>
            </div>
            <div class="pop_songs">
                <div class="h4">
                    <h4>Popular Songs</h4>
                    <div class="btn_s">
                        <i class="bi bi-arrow-left-circle" id="popSongLeft"></i>
                        <i class="bi bi-arrow-right-circle" id="popSongRight"></i>
                    </div>
                </div>
                <div class="songList">
                    <!-- <li class="perSong">
                        <div class="img_play">
                            <img src="img/1.jpg" alt="">
                            <i class="bi playListPlay bi-play-circle-fill" id="6"></i>
                        </div>
                        <div class="gDisp">
                            <h5>Willow<br></h5>
                            <h6 class="artist">Taylor Swift</h6>
                        </div>
                    </li> -->
                </div>
            </div>

        </div>
        <div class="colormix"></div>
    </header>
    <!-- <script src="app.js"></script> -->

</body>


</html>