<?php
include('dbConnect.php');
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header("Location:login.php");
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="library_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script type="text/javascript" src="app.js"></script> -->
    <title>MicroProject</title>
</head>

<body>
    <script>
        document.addEventListener(`DOMContentLoaded`, () => {
            let savedSongs = [];
            <?php
            $Ssql = "SELECT * FROM music_status WHERE user_id = $user_id ORDER BY music_id ASC";
            $Sresult = mysqli_query($con, $Ssql);
            if (mysqli_num_rows($Sresult) > 0) {
                while ($row = mysqli_fetch_assoc($Sresult)) {
                    $savedMusic_id = $row['music_id'];
                    $res = mysqli_query($con, "SELECT * FROM musics_db WHERE id = $savedMusic_id");
                    if (mysqli_num_rows($res) == 1) {
                        while ($Srow = mysqli_fetch_assoc($res)) {
                            $Smusic_id = $Srow['id'];
                            $SsongName = $Srow['songName'];
                            $SsongArtist = $Srow['songArtist'];
                            $Sposter = $Srow['poster'];
                            $Sduration = $Srow['duration'];
                            $Sratings = $Srow['ratings'];
                        }
                        ?>
                        savedSongs.push(
                            {
                                id: <?php echo $Smusic_id ?>,
                                songName: "<?php echo $SsongName ?>",
                                songArtist: "<?php echo $SsongArtist ?>",
                                poster: "<?php echo $Sposter ?>",
                                duration: "<?php echo $Sduration ?>",
                                ratings: <?php echo $Sratings ?>
                            }
                        );

                        <?php
                    }
                }
            }

            ?>
            console.log(savedSongs);
            /*********************Search Data Start********************/
            let searchResults = document.getElementsByClassName('searchResults')[0];
            savedSongs.forEach(element => {
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
            // // Get all the cards
            // const cards = document.querySelectorAll('.card');

            // // Add a click event listener to each card
            // cards.forEach(card => {
            //     card.addEventListener('click', function (event) {
            //         // Prevent the default action of the link
            //         event.preventDefault();

            //         // Get the id of the card from the href attribute
            //         const iden = this.getAttribute('href').substr(1);

            //         // Get the element with the corresponding id
            //         const elementing = document.getElementById(iden);

            //         // Scroll to the element using smooth scrolling
            //         elementing.scrollIntoView({
            //             behavior: 'smooth',
            //             block: 'start'
            //         });
            //     });
            // });
            /*********************Search Data End********************/
            /*********************playListDataStarts********************/
            let mainPlayList = document.getElementsByClassName('songList')[0];
            savedSongs.forEach(element => {
                const { id, songName, songArtist, poster, duration, ratings } = element;
                let songsCard = document.createElement('div');
                songsCard.classList.add('favSongCard');
                songsCard.id = `${id}`
                songsCard.innerHTML =
                    `<div class="srNo">${id}</div>
                        <div class="subCard">
                            <div class="imgBox">
                                <img src="${poster}" alt="">
                            </div>
                            <div class="dtCard">
                                <div class="songName">
                                    <h5>${songName}<h5>
                                </div>
                                <div class="artistName">
                                    <h5>${songArtist}</h5>
                                </div>
                                <div class="iconCard">
                                    <p class="duration">
                                        ${duration}
                                    </p>
                                    <p class="ratings">
                                    <i class="bi bi-person-fill"></i>
                                        ${ratings}
                                    </p>
                                    <p class="playC">
                                        <i class="bi playListPlay bi-play-fill" id="${id}" name="savedSongs"></i>
                                    </p>
                                    <p class="del">
                                        <i class="bi delSong bi-trash" id="${id}"></i>
                                    </p>
                                </div>
                            </div>
                        </div>`;
                        mainPlayList.appendChild(songsCard);



            });
            /*********************playListDataEnds********************/
            /*********************popSongsDataStarts********************/
            // let popPlayList = document.getElementsByClassName('songList')[0];
            // popSongs.forEach(element => {
            //     const { id, songName, songArtist, poster } = element;
            //     let popSongsCard = document.createElement('li');
            //     popSongsCard.classList.add('eachSong');

            //     popSongsCard.innerHTML = `<div class="img_play">
            //                               <img src="${poster}" alt="">
            //                               <i class="bi playListPlay bi-play-circle-fill" id="${id}" name="popularSongs"></i>
            //                               </div>
            //                               <div class="gDisp">
            //                               <h5>${songName}<br></h5>
            //                               <h6 class="artist">${songArtist}</h6>
            //                               </div>`;
            //     popPlayList.appendChild(popSongsCard);



            // });
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
            // var myDate = new Date();
            // var hrs = myDate.getHours();
            // var greet;
            // var smp = document.getElementById('wish')
            // if (hrs < 12)
            //     greet = 'Good Morning';
            // else if (hrs >= 12 && hrs <= 17)
            //     greet = 'Good Afternoon';
            // else if (hrs >= 17 && hrs <= 24)
            //     greet = 'Good Evening';

            // smp.innerHTML = greet;
            /*********************Popular Songs Move back and foward********************/
            // for scrolling the musics
            // let popSongLeft = document.getElementById('popSongLeft');
            // let popSongRight = document.getElementById('popSongRight');
            // let songList = document.getElementsByClassName('songList')[0];

            // popSongRight.addEventListener('click', () => {
            //     songList.scrollLeft += 330;
            // })
            // popSongLeft.addEventListener('click', () => {
            //     songList.scrollLeft -= 330;
            // })

            /*********************Popular Songs Move back and foward********************/
            // for scrolling the musics
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
                Array.from(document.getElementsByClassName('favSongCard')).forEach((el) => {
                    el.classList.remove('active');
                })
            }
            /*********************Indexing plays(Declaration)********************/
            // make the icons play whose music is not getting played
            const makeAllplays = () => {
                Array.from(document.getElementsByClassName('playListPlay')).forEach((el) => {
                    el.classList.add('bi-play-fill');
                    el.classList.remove('bi-pause-fill');
                })
            }
            /*********************Indexing songs********************/
            let lastPlayed;
            let index;
            let music_id;
            let state;
            let childNodesArrays;
            let update_cardIndex;
            let buttonArrays;
            let update_btnIndex;
            let likesAmount;
            let posterPlay = document.getElementById('posterPlay');
            let title = document.getElementById('title');
            let artist = document.getElementById('artist');
            let downBtn = document.getElementById('downloadMusic');
            let heartIcon = document.querySelector(".like-button .heart-icon");
            let likeLabel = document.querySelector(".likeCount");
            // let popSongsClass = 'eachSong';
            let savedSongsClass = 'favSongCard';
            /*********************playEvent********************/
            Array.from(document.getElementsByClassName('playListPlay')).forEach((e) => {
                e.addEventListener('click', playControl);
            })
            /*********************delEvent********************/
            Array.from(document.getElementsByClassName('delSong')).forEach((e) => {
                e.addEventListener('click', delControl);
            })
            /*********************playControl********************/
            let clickedList;
            function playControl(el) {
                clickedList = el.target.getAttribute('name');
                // if (clickedList === 'popularSongs') {
                //     indexSongs(popSongs, el, popSongsClass);
                // }
                if (clickedList === 'savedSongs') {
                    indexSongs(savedSongs, el, savedSongsClass);
                }
            }/*********************Duration Update********************/
            let durCon = document.getElementById('totalDur');
            let dispNo = document.getElementById('showNo');
            const updateDuration = () => {
                let totalDuration = 0;

                for (let i = 0; i < savedSongs.length; i++) {
                    const durationParts = savedSongs[i].duration.split(':');
                    const durationSeconds = parseInt(durationParts[0]) * 60 + parseInt(durationParts[1]);
                    totalDuration += durationSeconds;
                }

                let hours = Math.floor(totalDuration / 3600);
                let minutes = Math.floor((totalDuration % 3600) / 60);

                let output = '';

                if (hours >= 1) {
                    output += `${hours} hour${hours > 1 ? 's' : ''}`;
                }

                if (minutes >= 1) {
                    output += ` ${minutes} minute${minutes > 1 ? 's' : ''}`;
                }

                durCon.innerHTML = output.trim();
                console.log(output);
                dispNo.innerHTML = savedSongs.length + ' Songs';

            }
            /*********************delControl********************/
            let user_id = <?php echo $user_id; ?>;
            let del_index;
            updateDuration();
            function delControl(el) {
                del_index = savedSongs.findIndex(song => song.id === parseInt(el.target.id));
                music_id = el.target.id;
                let childNodesArray = Array.from(mainPlayList.childNodes);
                const del_cardIndex = childNodesArray.findIndex(node => node.nodeType === Node.ELEMENT_NODE && node.id === music_id);
                Array.from(mainPlayList.childNodes)[del_cardIndex].classList.add('delIt');
                let childToRemove = mainPlayList.childNodes[del_cardIndex];
                let childToRemoveSR = searchResults.childNodes[del_cardIndex]
                setTimeout(() => {
                    mainPlayList.removeChild(childToRemove);
                    searchResults.removeChild(childToRemoveSR);
                }, 500);
                console.log(savedSongs);
                if (del_index !== -1) {
                    savedSongs.splice(del_index, 1);
                    let xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText);
                        }
                    };
                    xhttp.open("POST", "deleteSong.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    let data = "music_id=" + music_id + "&user_id=" + user_id;
                    xhttp.send(data);
                    if (savedSongs.length === 0) {
                        setTimeout(() => {
                            window.location.href = "index.php";
                        }, 500);
                    }
                    if (index === del_index) {
                        if (index === savedSongs.length) {
                            index = 0;
                            music_id = savedSongs[index]['id'];
                            updateGUI(savedSongs, savedSongsClass);
                        }
                        else if (index < savedSongs.length) {
                            index;
                            music_id = savedSongs[index]['id'];
                            updateGUI(savedSongs, savedSongsClass);
                        }
                    }
                    updateDuration();
                }
                console.log(savedSongs);
                // location.reload();
            }
            /*********************Thumbnail********************/
            let thumbnail = document.getElementsByClassName('thumbnail')[0];
            if (savedSongs.length >= 4) {
                thumbnail.classList.remove('lessImg');
                const randomIndexes = [];
                while (randomIndexes.length < 4) {
                    const randomIndex = Math.floor(Math.random() * savedSongs.length);
                    if (!randomIndexes.includes(randomIndex)) {
                        randomIndexes.push(randomIndex);
                    }
                }
                randomIndexes.forEach(index => {
                    const { poster } = savedSongs[index];
                    const imgElement = document.createElement('img');
                    imgElement.src = poster;
                    imgElement.alt = "";
                    thumbnail.appendChild(imgElement);
                });
            } else {
                thumbnail.classList.add('lessImg');
                const imgElement = document.createElement('img');
                imgElement.src = "defaultThumbnail.jpg";
                imgElement.alt = "";
                thumbnail.appendChild(imgElement);
            }
            /*********************ProfileDt********************/

            /*********************Slike/dislike********************/
            // heartIcon.addEventListener("click", () => {
            //     if (state === 'liked') {
            //         heartIcon.classList.remove('liked');
            //         heartIcon.classList.add('unliked');
            //         state = 'unliked';
            //         likesAmount--;
            //         likeLabel.innerHTML = likesAmount;
            //         const ind = savedSongs.findIndex(song => parseInt(song.id) === parseInt(music_id));
            //         savedSongs[ind].status = 'unliked';
            //         savedSongs[ind].ratings--;
            //         const inde = popSongs.findIndex(song => parseInt(song.id) === parseInt(music_id));
            //         if (inde != -1) {
            //             popSongs[inde].status = 'unliked';
            //             popSongs[inde].ratings--;
            //         }
            //         let xhttp = new XMLHttpRequest();
            //         xhttp.onreadystatechange = function () {
            //             if (this.readyState == 4 && this.status == 200) {
            //                 console.log(this.responseText);
            //             }
            //         };
            //         xhttp.open("POST", "ratings.php", true);
            //         xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            //         let data = "music_id=" + music_id + "&user_id=" + user_id;
            //         xhttp.send(data);
            //     }
            //     else if (state === 'unliked') {
            //         heartIcon.classList.remove('unliked');
            //         heartIcon.classList.add('liked');
            //         state = 'liked';
            //         likesAmount++;
            //         likeLabel.innerHTML = likesAmount;
            //         const ind = savedSongs.findIndex(song => parseInt(song.id) === parseInt(music_id));
            //         savedSongs[ind].status = 'liked';
            //         savedSongs[ind].ratings++;
            //         const inde = popSongs.findIndex(song => parseInt(song.id) === parseInt(music_id));
            //         if (inde != -1) {
            //             popSongs[inde].status = 'liked';
            //             popSongs[inde].ratings++;
            //         }
            //         let xhttp = new XMLHttpRequest();
            //         xhttp.onreadystatechange = function () {
            //             if (this.readyState == 4 && this.status == 200) {
            //                 console.log(this.responseText);
            //             }
            //         };
            //         xhttp.open("POST", "ratings.php", true);
            //         xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            //         let data = "music_id=" + music_id + "&user_id=" + user_id;
            //         xhttp.send(data);
            //     }
            // })
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
                // let songRatings = songs.filter((els1) => {
                //     return els1.id == music_id;
                // })
                // let songStatus = songs.filter((els1) => {
                //     return els1.id == music_id;
                // })
                // songRatings.forEach(elss => {
                //     let { ratings } = elss;
                //     likeLabel.innerHTML = ratings;
                //     likesAmount = elss.ratings;
                // })
                // songStatus.forEach(elss1 => {
                //     let { status } = elss1;
                //     state = elss1.status;
                //     // let user_id = <?php echo $user_id; ?>;
                //     if (status === 'liked') {
                //         heartIcon.classList.remove('unliked');
                //         heartIcon.classList.add('liked');
                //     }
                //     if (status === 'unliked') {
                //         heartIcon.classList.remove('liked');
                //         heartIcon.classList.add('unliked');
                //     }
                // })
                if (songClass === 'favSongCard') {
                    // Array.from(document.getElementsByClassName('eachSong')).forEach((el) => {
                    //     el.style.background = 'rgba(128, 128, 128, 0)';
                    // })
                    makeAllBackground();
                    makeAllplays();
                    childNodesArrays = Array.from(mainPlayList.childNodes);
                    update_cardIndex = childNodesArrays.findIndex(node => node.nodeType === Node.ELEMENT_NODE && parseInt(node.id) === music_id);
                    Array.from(mainPlayList.childNodes)[update_cardIndex].classList.add('active');
                    buttonArrays = Array.from(document.getElementsByName('savedSongs'));
                    update_btnIndex = buttonArrays.findIndex(node => node.nodeType === Node.ELEMENT_NODE && parseInt(node.id) === music_id);
                    buttonArrays[update_btnIndex].classList.remove('bi-play-fill');
                    buttonArrays[update_btnIndex].classList.add('bi-pause-fill');
                    // Array.from(document.getElementsByClassName(songClass))[index].classList.add('active');
                    // Array.from(document.getElementsByName('savedSongs'))[index].classList.remove('bi-play-fill');
                    // Array.from(document.getElementsByName('savedSongs'))[index].classList.add('bi-pause-fill');
                }
                // if (songClass === 'eachSong') {
                //     // Array.from(document.getElementsByClassName('favSongCard')).forEach((el) => {
                //     //     el.style.background = 'rgba(128, 128, 128, 0)';
                //     // })
                //     Array.from(document.getElementsByClassName(songClass)).forEach((el) => {
                //         el.style.background = 'rgba(128, 128, 128, 0)';
                //     })
                //     Array.from(document.getElementsByClassName(songClass))[index].style.background = 'rgba(128, 128, 128, 0.251)';
                //     makeAllplays();
                //     Array.from(document.getElementsByName('popularSongs'))[index].classList.remove('bi-play-circle-fill');
                //     Array.from(document.getElementsByName('popularSongs'))[index].classList.add('bi-pause-circle-fill');
                // }
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
                if (clickedList === 'savedSongs') {
                    index -= 1;
                    if (index < 0) {
                        index = Array.from(document.getElementsByClassName('favSongCard')).length - 1;
                        music_id = savedSongs[savedSongs.length - 1]['id'];
                    }
                    else {
                        music_id = savedSongs[index]['id'];
                    }
                    updateGUI(savedSongs, savedSongsClass);
                }
                // else if (clickedList === 'popularSongs') {
                //     index -= 1;
                //     if (index < 0) {
                //         index = Array.from(document.getElementsByClassName('eachSong')).length - 1;
                //         music_id = popSongs[popSongs.length - 1]['id'];
                //     }
                //     else {
                //         music_id = popSongs[index]['id'];
                //     }
                //     updateGUI(popSongs, popSongsClass);
                // }
            })

            next.addEventListener('click', () => {
                if (clickedList === 'savedSongs') {
                    if (index === savedSongs.length - 1) {
                        index = 0;
                        music_id = savedSongs[index]['id'];
                    }
                    else if (index < savedSongs.length - 1) {
                        index++;
                        music_id = savedSongs[index]['id'];
                    }
                    updateGUI(savedSongs, savedSongsClass);
                }
                // else if (clickedList === 'popularSongs') {
                //     if (index === popSongs.length - 1) {
                //         index = 0;
                //         music_id = popSongs[index]['id'];
                //     }
                //     else if (index < popSongs.length - 1) {
                //         index++;
                //         music_id = popSongs[index]['id'];
                //     }
                //     updateGUI(popSongs, popSongsClass);
                // }
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
                if (clickedList === 'savedSongs') {
                    if (index === savedSongs.length - 1) {
                        index = 0;
                        music_id = savedSongs[index]['id'];
                    }
                    else if (index < savedSongs.length - 1) {
                        index++;
                        music_id = savedSongs[index]['id'];
                    }
                    updateGUI(savedSongs, savedSongsClass);
                }
                // else if (clickedList === 'popularSongs') {
                //     if (index === popSongs.length - 1) {
                //         index = 0;
                //         music_id = popSongs[index]['id'];
                //     }
                //     else if (index < popSongs.length - 1) {
                //         index++;
                //         music_id = popSongs[index]['id'];
                //     }
                //     updateGUI(popSongs, popSongsClass);
                // }
            }
            const repeatMusic = () => {
                // this func will play one music repetively
                if (clickedList === 'savedSongs') {
                    index;
                    music_id;
                    updateGUI(savedSongs, savedSongsClass);
                }
                // else if (clickedList === 'popularSongs') {
                //     index;
                //     music_id;
                //     updateGUI(popSongs, popSongsClass);
                // }
            }
            const randomMusic = () => {
                // this func will play music randomly
                if (clickedList === 'savedSongs') {
                    if (index === savedSongs.length - 1) {
                        index = 0;
                        music_id = savedSongs[index]['id'];
                    }
                    else if (index < savedSongs.length - 1) {
                        index = Math.floor((Math.random() * savedSongs.length));
                        console.log(index);
                        music_id = savedSongs[index]['id'];
                    }
                    updateGUI(savedSongs, savedSongsClass);
                }
                // else if (clickedList === 'popularSongs') {
                //     if (index === popSongs.length - 1) {
                //         index = 0;
                //         music_id = popSongs[index]['id'];
                //     }
                //     else if (index < popSongs.length - 1) {
                //         index = Math.floor((Math.random() * popSongs.length));
                //         console.log(index);
                //         music_id = popSongs[index]['id'];
                //     }
                //     updateGUI(popSongs, popSongsClass);
                // }
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
                // let songRatings = songs.filter((els1) => {
                //     return els1.id == music_id;
                // })
                // let songStatus = songs.filter((els1) => {
                //     return els1.id == music_id;
                // })
                // songRatings.forEach(elss => {
                //     let { ratings } = elss;
                //     likeLabel.innerHTML = ratings;
                //     likesAmount = elss.ratings;
                // })
                // songStatus.forEach(elss1 => {
                //     let { status } = elss1;
                //     state = elss1.status;
                //     // let user_id = <?php echo $user_id; ?>;
                //     if (status === 'liked') {
                //         heartIcon.classList.remove('unliked');
                //         heartIcon.classList.add('liked');
                //     }
                //     if (status === 'unliked') {
                //         heartIcon.classList.remove('liked');
                //         heartIcon.classList.add('unliked');
                //     }
                // })
                if (songClass === 'favSongCard') {
                    // Array.from(document.getElementsByClassName('eachSong')).forEach((el) => {
                    //     el.style.background = 'rgba(128, 128, 128, 0)';
                    // })
                    makeAllBackground();
                    makeAllplays();
                    Array.from(document.getElementsByClassName(songClass))[index].classList.add('active');
                    Array.from(document.getElementsByName('savedSongs'))[index].classList.remove('bi-play-fill');
                    Array.from(document.getElementsByName('savedSongs'))[index].classList.add('bi-pause-fill');
                }
                // if (songClass === 'eachSong') {
                //     Array.from(document.getElementsByClassName('favSongCard')).forEach((el) => {
                //         el.style.background = 'rgba(128, 128, 128, 0)';
                //     })
                //     Array.from(document.getElementsByClassName(songClass)).forEach((el) => {
                //         el.style.background = 'rgba(128, 128, 128, 0)';
                //     })
                //     Array.from(document.getElementsByClassName(songClass))[index].style.background = 'rgba(128, 128, 128, 0.251)';
                //     makeAllplays();
                //     el.target.classList.remove('bi-play-circle-fill');
                //     el.target.classList.add('bi-pause-circle-fill');
                // }
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
        <?php
        $select = mysqli_query($con, "SELECT * FROM `userdetails` WHERE id = '$user_id'");
        if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
        } ?>
        <div class="menu">
            <div class="thumbnail">
                <!-- <img src="" alt="">
                <img src="" alt="">
                <img src="" alt="">
                <img src="" alt=""> -->
            </div>
            <div class="profileDetails">
                <div class="headDt">
                    <div class="no_LikeSongs">
                        <i class="bi bi-vinyl-fill"></i>
                        <div id="showNo"></div>
                    </div>
                    <div class="no_TotalDuration" id="totalDur"></div>
                </div>
                <div class="userName">
                    <?php echo $fetch['username']; ?>
                </div>
            </div>
            <div class="profilePic">
                <?php
                echo '<img src="userPFPs/' . $fetch['pfp'] . '">';
                ?>
            </div>
        </div>
        <div class="song">
            <nav>
                <ul>
                    <li><a href="index.php">DISCOVER</a></li>
                    <li>MY LIBRARY <span></span></li>
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
            <div class="pop_songs">
                <div class="h4">
                    <h4>Your Liked Songs</h4>
                </div>
                <div class="headings">
                    <li>#</li>
                    <li>Title</li>
                    <li>Album</li>
                    <li><i class="bi bi-clock"></i></li>
                    <li><i class="bi bi-suit-heart"></i></li>
                </div>
                <div class="songList">
                    <!-- <div class="favSongCard">
                        <div class="srNo">#100</div>
                        <div class="subCard">
                            <div class="imgBox">
                                <img src="" alt="">
                            </div>
                            <div class="dtCard">
                                <div class="songName">
                                    <h5>songNamebdfddddddddddddddddddddddddddddddddddddfgsagfsbhbjhnkjnd<h5>
                                </div>
                                <div class="artistName">
                                    <h5>artistName</h5>
                                </div>
                                <div class="iconCard">
                                    <p class="duration">
                                        00:00
                                    </p>
                                    <p class="ratings">
                                    <i class="bi bi-person-fill"></i>
                                        9
                                    </p>
                                    <p class="playC">
                                        <i class="bi bi-play-fill"></i>
                                    </p>
                                    <p class="del">
                                        <i class="bi bi-trash"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="colormix"></div>
    </header>
    <!-- <script src="app.js"></script> -->

</body>


</html>