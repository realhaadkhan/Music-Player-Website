<?php
include('dbConnect.php');
session_start();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_main_style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>MicroProject</title>
</head>

<body>
    <script>
        document.addEventListener(`DOMContentLoaded`, () => {
            let allSongs = [];
            let totalUsers;
            <?php
            $Cntresult = mysqli_query($con, "SELECT COUNT(*) as count FROM userdetails");
            $roww = mysqli_fetch_assoc($Cntresult);
            $count = $roww['count'];
            $sql = "SELECT * FROM musics_db ORDER BY id ASC";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $music_id = $row['id'];
                    $poster = $row['poster'];
                    $songName = $row['songName'];
                    $songArtist = $row['songArtist'];
                    $duration = $row['duration'];
                    $ratings = $row['ratings'];
                    ?>
                    allSongs.push(
                        {
                            id: <?php echo $music_id ?>,
                            poster: "<?php echo $poster ?>",
                            songName: "<?php echo $songName ?>",
                            songArtist: "<?php echo $songArtist ?>",
                            duration: "<?php echo $duration ?>",
                            ratings: <?php echo $ratings ?>
                        }
                    );

                    <?php
                }
            }

            ?>
            console.log(allSongs);
            /*********************playListDataStarts********************/
            let mainPlayList = document.getElementsByClassName('songList')[0];
            allSongs.forEach(element => {
                const { id, poster, songName, songArtist, duration, ratings } = element;
                let songsCard = document.createElement('div');
                songsCard.classList.add('favSongCard');
                songsCard.id = `${id}`;
                songsCard.innerHTML =
                    `
                    <span class="addIcon"><i class="bi addSongUp bi-plus-circle-fill" id="${id}"></i>
                                          <i class="bi addSongDown bi-plus-circle-fill" id="${id}"></i></span>
                    <div class="srNo">${id}</div>
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
                                    <p class="del">
                                        <i class="bi delSong bi-trash" id="${id}"></i>
                                    </p>
                                </div>
                            </div>
                        </div>`;
                mainPlayList.appendChild(songsCard);
            });

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

            let lastPlayed;
            let index;
            let music_id;
            let childNodesArrays;
            let update_cardIndex;
            let buttonArrays;
            let update_btnIndex;
            let currentAddUpOrDown;
            let userAmount = document.getElementById('userAmount');
            userAmount.innerHTML = <?php echo ($count); ?>;
            let songAmount = document.getElementById('songAmount');
            let famousSongAmount = document.getElementById('famousSongAmount');
            const updateDashBoard = () => {
                songAmount.innerHTML = allSongs.length;
                let filteredSongs = allSongs.filter(song => song.ratings > 3);
                famousSongAmount.innerHTML = filteredSongs.length;
            }
            updateDashBoard();
            // let popSongsClass = 'eachSong';
            let savedSongsClass = 'favSongCard';
            /*********************delEvent********************/
            Array.from(document.getElementsByClassName('delSong')).forEach((e) => {
                e.addEventListener('click', delControl);
            })
            /*********************addSongEvent********************/
            Array.from(document.getElementsByClassName('addSongUp')).forEach((e) => {
                e.addEventListener('click', addSongControlUp);
            })
            Array.from(document.getElementsByClassName('addSongDown')).forEach((e) => {
                e.addEventListener('click', addSongControlDown);
            })
            /*********************updatePlusIconOnload********************/
            let nonConsCard_idUp = [];
            let nonConsCard_idDown = [];
            let filteredIdsUp = allSongs.reduce((acc, obj, idx) => {
                if (idx === 0 && obj.id > 1) {
                    acc.push(obj.id);
                } else if (idx !== 0 && obj.id - allSongs[idx - 1].id > 1) {
                    acc.push(obj.id);
                }
                return acc;
            }, []);
            nonConsCard_idUp = nonConsCard_idUp.concat(filteredIdsUp)
            // console.log(filteredIdsUp);
            let filteredIdsDown = allSongs.reduce((acc, obj, idx) => {
                if (idx !== allSongs.length - 1 && allSongs[idx + 1].id - obj.id > 1) {
                    acc.push(obj.id);
                }
                return acc;
            }, []);
            nonConsCard_idDown = nonConsCard_idDown.concat(filteredIdsDown)
            // console.log(filteredIdsDown);
            /*********************delControl********************/
            let del_index;
            // let ifIdPresent = allSongs.find(song => parseInt(song.id) === 1);
            // if (ifIdPresent === undefined) {
            //     nonConsCard_idUp.push(allSongs[0].id);
            // }
            let last_index = allSongs.length - 1;
            nonConsCard_idDown.push(allSongs[last_index].id);
            function delControl(el) {
                del_index = allSongs.findIndex(song => song.id === parseInt(el.target.id));
                music_id = el.target.id;
                let childNodesArray = Array.from(mainPlayList.childNodes);
                let del_cardIndex = childNodesArray.findIndex(node => node.nodeType === Node.ELEMENT_NODE && node.id === music_id);
                console.log('ddzsagvvsssssssssssssss')
                Array.from(mainPlayList.childNodes)[del_cardIndex].classList.add('delIt');
                let childToRemove = mainPlayList.childNodes[del_cardIndex];
                let childToRemoveSR = searchResults.childNodes[del_cardIndex]
                setTimeout(() => {
                    mainPlayList.removeChild(childToRemove);
                    searchResults.removeChild(childToRemoveSR);
                }, 500);
                console.log(allSongs);
                if (del_index !== -1) {
                    allSongs.splice(del_index, 1);
                    let xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText);
                        }
                    };
                    xhttp.open("POST", "deleteExistSong.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    let data = "music_id=" + music_id;
                    xhttp.send(data);
                    updateDashBoard();
                    nonConsCard_idUp = [];
                    nonConsCard_idDown = [];
                    let ifIdPresent = allSongs.find(song => parseInt(song.id) === 1);
                    console.log('gf', ifIdPresent);
                    if (ifIdPresent === undefined) {
                        nonConsCard_idUp.push(allSongs[0].id);
                    }
                    let last_index = allSongs.length - 1;
                    nonConsCard_idDown.push(allSongs[last_index].id);
                    for (let i = 0; i < allSongs.length; i++) {
                        if (allSongs[i - 1] && allSongs[i - 1].id !== allSongs[i].id - 1) {
                            nonConsCard_idUp.push(allSongs[i].id);
                        }
                        if (allSongs[i + 1] && allSongs[i + 1].id !== allSongs[i].id + 1) {
                            nonConsCard_idDown.push(allSongs[i].id);
                        }
                    }
                    // let xhttp = new XMLHttpRequest();
                    // xhttp.onreadystatechange = function () {
                    //     if (this.readyState == 4 && this.status == 200) {
                    //         console.log(this.responseText);
                    //     }
                    // };
                    // xhttp.open("POST", "deleteSong.php", true);
                    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    // let data = "music_id=" + music_id + "&user_id=" + user_id;
                    // xhttp.send(data);
                    if (allSongs.length === 0) {
                        setTimeout(() => {
                            window.location.href = "login.php";
                        }, 500);
                    }
                }
                console.log(allSongs);
                // location.reload();
            }
            /*********************onHoverListener********************/
            let hovSong = document.getElementById('hovSong');
            let favSongArrays = Array.from(document.getElementsByClassName('favSongCard'));
            let childNodesArray;
            console.log(nonConsCard_idUp);
            console.log(nonConsCard_idDown);
            hovSong.addEventListener('mouseover', () => {
                if (nonConsCard_idUp.length > 0) {
                    nonConsCard_idUp.forEach((id) => {
                        childNodesArray = Array.from(mainPlayList.children);
                        let addConstCard_index = childNodesArray.findIndex(node => node.nodeType === Node.ELEMENT_NODE && parseInt(node.id) === id);
                        addIconSpan = childNodesArray[addConstCard_index].querySelector('.addSongUp');
                        addIconSpan.classList.add('tenty');
                        // if (addConstCard_index !== -1) {
                        //     favSongArrays[addConstCard_index].insertAdjacentHTML('afterbegin', `<span class="addIcon" id="${id}"><i class="bi bi-plus-circle-fill"></i></span>`);
                        // }
                    });
                    // console.log(nonConsCard_idUp);
                }
                if (nonConsCard_idDown.length > 0) {
                    nonConsCard_idDown.forEach((id) => {
                        childNodesArray = Array.from(mainPlayList.children);
                        let addConstCard_index = childNodesArray.findIndex(node => node.nodeType === Node.ELEMENT_NODE && parseInt(node.id) === id);
                        addIconSpan = childNodesArray[addConstCard_index].querySelector('.addSongDown');
                        addIconSpan.classList.add('tenty');
                        // if (addConstCard_index !== -1) {
                        //     favSongArrays[addConstCard_index].insertAdjacentHTML('afterbegin', `<span class="addIcon" id="${id}"><i class="bi bi-plus-circle-fill"></i></span>`);
                        // }
                    });
                    // console.log(nonConsCard_idDown);
                }
            });
            let form = document.querySelector('form');
            /*********************addSongControl********************/
            let popInput = document.getElementsByClassName('popInput')[0];
            let addSongUp_index;
            let addSongDown_index;
            let newSong;
            function addSongControlUp(el) {
                popInput.classList.add('active');
                addSongUp_index = allSongs.findIndex(song => song.id === parseInt(el.target.id));
                music_id = parseInt(el.target.id);
                music_id -= 1;
                currentAddUpOrDown = 'AddUp';
                console.log('dfvghjkl')
                console.log('Song to add is ', music_id);
            }
            function addSongControlDown(el) {
                popInput.classList.add('active');
                addSongDown_index = allSongs.findIndex(song => song.id === parseInt(el.target.id));
                addSongDown_index += 1
                console.log(allSongs);
                music_id = parseInt(el.target.id);
                console.log('It was the Last added Song', music_id)
                music_id += 1;
                currentAddUpOrDown = 'AddDown';
                console.log('Song to add is ', music_id);
                console.log('It Previous Element will be', music_id - 1)
                // addSong_index = allSongs.findIndex(song => song.id === parseInt(el.target.id));
                // music_id = el.target.id;
                // addSong_index = allSongs.findIndex(song => song.id === parseInt(el.target.id));
                // music_id = el.target.id;
                // let childNodesArray = Array.from(mainPlayList.childNodes);
                // const del_cardIndex = childNodesArray.findIndex(node => node.nodeType === Node.ELEMENT_NODE && node.id === music_id);
                // Array.from(mainPlayList.childNodes)[del_cardIndex].classList.add('delIt');
                // let childToRemove = mainPlayList.childNodes[del_cardIndex];
                // setTimeout(() => {
                //     mainPlayList.removeChild(childToRemove);
                // }, 500);
                // console.log(allSongs);
                // if (del_index !== -1) {
                //     allSongs.splice(del_index, 1);
                // let xhttp = new XMLHttpRequest();
                // xhttp.onreadystatechange = function () {
                //     if (this.readyState == 4 && this.status == 200) {
                //         console.log(this.responseText);
                //     }
                // };
                // xhttp.open("POST", "deleteSong.php", true);
                // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                // let data = "music_id=" + music_id + "&user_id=" + user_id;
                // xhttp.send(data);
                // }
                // location.reload();
            }
            let closeBtn = document.getElementsByClassName('closeBtn')[0];
            closeBtn.addEventListener('click', () => {
                popInput.classList.remove('active');
            })

            form.addEventListener('submit', (event) => {
                event.preventDefault(); // Prevent the form from submitting
                uploadTheSong();
            })
            /*********************uploadSong Thumbnail********************/
            let uploadThumbnail = document.querySelector('.uploadThumbnail');
            let photo = document.querySelector('#photo');
            let filee = document.querySelector('#filess');
            let uploadBtn = document.querySelector('#uploadBtn');

            filee.addEventListener('change', () => {
                const chosedFile = filee.files[0];
                if (chosedFile) {
                    const reader = new FileReader();

                    reader.addEventListener('load', () => {
                        photo.setAttribute('src', reader.result);
                    });
                    reader.readAsDataURL(chosedFile);
                }
            });

            /*********************upload SONGGGGGGG!!********************/
            const uploadTheSong = () => {

                // Add event listener on submit

                // Get the form data
                let formData = new FormData(event.target);
                let imageFile = formData.get('imagee');
                let imageObject = filee.files[0];
                let songPoster = URL.createObjectURL(imageFile);
                let songName = formData.get('songName');
                let artistName = formData.get('artistName');
                let audioFile = formData.get('audio');
                let audio = new Audio(URL.createObjectURL(audioFile));
                let audioDuration;
                audio.addEventListener('loadedmetadata', () => {
                    let duration = audio.duration;
                    let minutes = Math.floor(duration / 60);
                    let seconds = Math.floor(duration % 60);
                    let formattedDuration = `${minutes < 10 ? '0' + minutes : minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
                    audioDuration = formattedDuration;
                    let songRatings = 0;

                    newSong = document.createElement('div');
                    newSong.classList.add('favSongCard');
                    newSong.classList.add('swp');
                    newSong.id = music_id;
                    newSong.innerHTML =
                        `
                    <span class="addIcon"><i class="bi addSongUp bi-plus-circle-fill" id="${music_id}"></i>
                                          <i class="bi addSongDown bi-plus-circle-fill" id="${music_id}"></i></span>
                    <div class="srNo">${music_id}</div>
                        <div class="subCard">
                            <div class="imgBox">
                                <img src="${songPoster}" alt="">
                            </div>
                            <div class="dtCard">
                                <div class="songName">
                                    <h5>${songName}<h5>
                                </div>
                                <div class="artistName">
                                    <h5>${artistName}</h5>
                                </div>
                                <div class="iconCard">
                                    <p class="duration">
                                        ${audioDuration}
                                    </p>
                                    <p class="ratings">
                                        <i class="bi bi-person-fill"></i>
                                        ${songRatings}
                                    </p>
                                    <p class="del">
                                        <i class="bi delSong bi-trash" id="${music_id}"></i>
                                    </p>
                                </div>
                            </div>
                        </div>`;
                    let Newcard = document.createElement('a');
                    Newcard.classList.add('card');
                    Newcard.innerHTML = `<img src="${songPoster}" alt="">
                          <div class="content">
                              <h5>${songName}<br></h5>
                              <h6 class="artist">${artistName}</h6>
                          </div>`;
                    Newcard.href = "#" + music_id;
                    if (currentAddUpOrDown === 'AddUp') {
                        let indexWhereToAdd = Array.from(mainPlayList.children).findIndex(node => node.nodeType === Node.ELEMENT_NODE && parseInt(node.id) === parseInt(music_id + 1));
                        let existingChild = Array.from(mainPlayList.children)[indexWhereToAdd];
                        searchResults.insertBefore(Newcard, Array.from(searchResults.children)[indexWhereToAdd]);
                        mainPlayList.insertBefore(newSong, existingChild);
                        setTimeout(() => {
                            mainPlayList.children[indexWhereToAdd].classList.remove('swp');
                        }, 100);
                        let newSongObj = {
                            id: music_id,
                            poster: `${songPoster}`.toString(),
                            songName: `${songName}`.toString(),
                            songArtist: `${artistName}`.toString(),
                            duration: `${audioDuration}`.toString(),
                            ratings: `${songRatings}`.toString()
                        }
                        allSongs.splice(addSongUp_index, 0, newSongObj);
                        // let form = document.querySelector('form');
                        // let formData = new FormData();
                        let xhttp1 = new XMLHttpRequest();
                        xhttp1.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {
                                console.log(this.responseText);
                            }
                        };
                        xhttp1.open("POST", "addNewSong.php", true);
                        formData.append('music_id', music_id);
                        formData.append('ratings', songRatings);
                        formData.append('duration', audioDuration);
                        xhttp1.send(formData);
                        updateDashBoard();
                        let tmpId = music_id + 1;
                        console.log('The array is ', nonConsCard_idUp);
                        console.log('The array is ', nonConsCard_idDown);
                        // if ((indexWhereToAdd - 1) > 0) {
                        //     console.log('the above id is ', mainPlayList.children[indexWhereToAdd - 1].id)
                        //     let remNonConsCard_index1 = nonConsCard_idDown.findIndex(element => parseInt(element) === parseInt(mainPlayList.children[indexWhereToAdd - 1].id));
                        //     console.log('The result is ', remNonConsCard_index1, ' and the element is ', nonConsCard_idDown[remNonConsCard_index1])
                        // }
                        let remNonConsCard_index = nonConsCard_idUp.findIndex(element => parseInt(element) === parseInt(mainPlayList.children[indexWhereToAdd + 1].id));
                        console.log('The result is ', remNonConsCard_index, ' and the element is ', nonConsCard_idUp[remNonConsCard_index])
                        let checkifIdisThere = allSongs.findIndex(ben => ben.id === music_id);
                        if (checkifIdisThere === -1) {
                            // nonConsCard_idUp.splice(nonConsCard_idUp.length - 1, 0, tmpId);
                        }
                        else {
                            nonConsCard_idUp.splice(remNonConsCard_index, 1);
                            if ((indexWhereToAdd - 1) > 0) {
                                let remNonConsCard_index1 = nonConsCard_idDown.findIndex(element => parseInt(element) === parseInt(mainPlayList.children[indexWhereToAdd - 1].id));
                                nonConsCard_idDown.splice(remNonConsCard_index1, 1);
                            }
                        }
                        console.log(nonConsCard_idUp)
                        console.log(nonConsCard_idDown)
                        if (remNonConsCard_index !== -1) {
                            childNodesArray = Array.from(mainPlayList.children);
                            console.log('refreshed...')
                            let remConstCard_index = childNodesArray.findIndex(node => node.nodeType === Node.ELEMENT_NODE && parseInt(node.id) === parseInt(tmpId));
                            addIconSpan = childNodesArray[remConstCard_index].querySelector('.addSongUp');
                            addIconSpan.classList.remove('tenty');
                            console.log(remConstCard_index);
                            let listToaddaddUp = childNodesArray[remConstCard_index - 1].querySelector('.addSongUp');
                            console.log(nonConsCard_idUp)
                            console.log(nonConsCard_idDown)
                            console.log('ok! so the currently added song id is ', childNodesArray[remConstCard_index - 1])
                            if ((indexWhereToAdd - 1) > 0) {
                                childNodesArray[remConstCard_index - 2].querySelector('.addSongDown').classList.remove('tenty');
                            }
                            if (remConstCard_index - 1 > 0) {
                                if ((parseInt(childNodesArray[remConstCard_index - 1].id) - parseInt(childNodesArray[remConstCard_index - 2].id) !== 1)) {
                                    listToaddaddUp.classList.add('tenty');
                                    console.log('Add icon is added to song Id', childNodesArray[remConstCard_index - 1].id, ' which is present after song Id ', childNodesArray[remConstCard_index - 2].id, ' and before song Id ', childNodesArray[remConstCard_index].id);
                                    nonConsCard_idUp.splice(nonConsCard_idUp.length - 1, 0, music_id);
                                    nonConsCard_idDown.splice(nonConsCard_idDown.length - 1, 0, parseInt(childNodesArray[remConstCard_index - 2].id));
                                    console.log(nonConsCard_idUp)
                                    console.log(nonConsCard_idDown)
                                }
                            }
                            else {
                                if (parseInt(childNodesArray[remConstCard_index - 1].id) !== 1) {
                                    listToaddaddUp.classList.add('tenty');
                                    console.log('Add icon is added to song Id', childNodesArray[remConstCard_index - 1].id, ' which is present before song Id ', childNodesArray[remConstCard_index].id);
                                    nonConsCard_idUp.splice(nonConsCard_idUp.length - 1, 0, music_id);
                                }
                            }
                            let listToadddel = childNodesArray[remConstCard_index - 1].querySelector('.delSong');
                            listToadddel.addEventListener('click', delControl);
                            listToaddaddUp.addEventListener('click', addSongControlUp);
                        }
                    }
                    else if (currentAddUpOrDown === 'AddDown') {
                        let indexWhereToAdd = Array.from(mainPlayList.children).findIndex(node => node.nodeType === Node.ELEMENT_NODE && parseInt(node.id) === parseInt(music_id - 1));
                        let existingChild = Array.from(mainPlayList.children)[indexWhereToAdd];
                        searchResults.insertBefore(Newcard, Array.from(searchResults.children)[indexWhereToAdd].nextElementSibling);
                        mainPlayList.insertBefore(newSong, existingChild.nextElementSibling);
                        setTimeout(() => {
                            mainPlayList.children[indexWhereToAdd + 1].classList.remove('swp');
                        }, 100);
                        let newSongObj = {
                            id: music_id,
                            poster: `${songPoster}`.toString(),
                            songName: `${songName}`.toString(),
                            songArtist: `${artistName}`.toString(),
                            duration: `${audioDuration}`.toString(),
                            ratings: `${songRatings}`.toString()
                        }
                        allSongs.splice(addSongDown_index, 0, newSongObj);
                        // let form = document.querySelector('form');
                        // let formData = new FormData();
                        let xhttp1 = new XMLHttpRequest();
                        xhttp1.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {
                                console.log(this.responseText);
                            }
                        };
                        xhttp1.open("POST", "addNewSong.php", true);
                        formData.append('music_id', music_id);
                        formData.append('ratings', songRatings);
                        formData.append('duration', audioDuration);
                        xhttp1.send(formData);
                        updateDashBoard();
                        //tmpId upar waala
                        let tmpId = music_id - 1;
                        console.log('The array is ', nonConsCard_idUp);
                        console.log('The array is ', nonConsCard_idDown);
                        // if ((indexWhereToAdd - 1) > 0) {
                        //     console.log('the above id is ', mainPlayList.children[indexWhereToAdd - 1].id)
                        //     let remNonConsCard_index1 = nonConsCard_idDown.findIndex(element => parseInt(element) === parseInt(mainPlayList.children[indexWhereToAdd - 1].id));
                        //     console.log('The result is ', remNonConsCard_index1, ' and the element is ', nonConsCard_idDown[remNonConsCard_index1])
                        // }
                        //remNonConsCard_index upar waala
                        let remNonConsCard_index = nonConsCard_idDown.findIndex(element => parseInt(element) === parseInt(mainPlayList.children[indexWhereToAdd].id));
                        console.log('The above node is ', mainPlayList.children[indexWhereToAdd].id)
                        console.log('The result is ', remNonConsCard_index, ' and the element is ', nonConsCard_idDown[remNonConsCard_index])
                        let checkifIdisThere = allSongs.findIndex(ben => ben.id === music_id);
                        if (checkifIdisThere === -1) {
                            // nonConsCard_idUp.splice(nonConsCard_idUp.length - 1, 0, tmpId);
                        }
                        else {
                            nonConsCard_idDown.splice(remNonConsCard_index, 1);
                            if ((indexWhereToAdd + 1) < allSongs.length - 1) {
                                let remNonConsCard_index1 = nonConsCard_idUp.findIndex(element => parseInt(element) === parseInt(mainPlayList.children[indexWhereToAdd + 2].id));
                                console.log(remNonConsCard_index1)
                                console.log('The result is ', remNonConsCard_index1, ' and the element is ', nonConsCard_idUp[remNonConsCard_index1])
                                nonConsCard_idUp.splice(remNonConsCard_index1, 1);
                            }
                        }
                        console.log(nonConsCard_idUp)
                        console.log(nonConsCard_idDown)
                        if (remNonConsCard_index !== -1) {
                            childNodesArray = Array.from(mainPlayList.children);
                            console.log('refreshed...')
                            let remConstCard_index = childNodesArray.findIndex(node => node.nodeType === Node.ELEMENT_NODE && parseInt(node.id) === parseInt(tmpId));
                            addIconSpan = childNodesArray[remConstCard_index].querySelector('.addSongDown');
                            addIconSpan.classList.remove('tenty');
                            console.log(remConstCard_index);
                            let listToaddaddDown = childNodesArray[remConstCard_index + 1].querySelector('.addSongDown');
                            // console.log(childNodesArray[remConstCard_index + 1].id)
                            console.log(nonConsCard_idUp)
                            console.log(nonConsCard_idDown)
                            console.log('ok! so the currently added song id is ', childNodesArray[remConstCard_index + 1])
                            if ((indexWhereToAdd + 1) < allSongs.length - 1) {
                                childNodesArray[remConstCard_index + 2].querySelector('.addSongUp').classList.remove('tenty');
                            }
                            if ((indexWhereToAdd + 1) < allSongs.length - 1) {
                                if ((parseInt(childNodesArray[remConstCard_index + 2].id) - parseInt(childNodesArray[remConstCard_index + 1].id) !== 1)) {
                                    listToaddaddDown.classList.add('tenty');
                                    console.log('Add icon is added to song Id', childNodesArray[remConstCard_index + 1].id, ' which is present before song Id ', childNodesArray[remConstCard_index + 2].id, ' and after song Id ', childNodesArray[remConstCard_index].id);
                                    nonConsCard_idDown.splice(nonConsCard_idDown.length - 1, 0, music_id);
                                    nonConsCard_idUp.splice(nonConsCard_idUp.length - 1, 0, parseInt(childNodesArray[remConstCard_index + 2].id));
                                    console.log(nonConsCard_idUp)
                                    console.log(nonConsCard_idDown)

                                }
                            }
                            else {
                                if ((indexWhereToAdd + 1) == allSongs.length - 1) {
                                    listToaddaddDown.classList.add('tenty');
                                    console.log('Add icon is added to song Id', childNodesArray[remConstCard_index + 1].id, ' which is present after song Id ', childNodesArray[remConstCard_index].id);
                                    nonConsCard_idDown.splice(nonConsCard_idDown.length - 1, 0, music_id);
                                }
                            }
                            let listToadddel = childNodesArray[remConstCard_index + 1].querySelector('.delSong');
                            listToadddel.addEventListener('click', delControl);
                            listToaddaddDown.addEventListener('click', addSongControlDown);
                        }
                    }
                    console.log(allSongs);
                    photo.setAttribute('src', '');
                    form.reset();
                    popInput.classList.remove('active');
                });

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
    <header>
        <div class="menu">
            <div class="logoNname">
                <img src="adminLogo.png" alt="">
                <h2>PHP MP</h2>
            </div>
            <div class="items">
                <li><i class="bi bi-clipboard-data"></i><a href="#">DashBoard</a></li>
            </div>
        </div>
        <div class="board">
            <nav>
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
                        <img src="admin_pfp.jpg" alt="">
                    </div>
                    <div class="profile-dropDown-List" id="pfdrp">
                        <h4>
                            <div class="use">
                                <img src="admin_pfp.jpg" alt="">
                            </div>
                            <div class="dtl"></div>
                            Admin
                            <div>
                                admin@gmail.com
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
            <div class="overview">
                <div class="h4">
                    <h4>Overview</h4>
                </div>
                <div class="card">
                    <li>
                        <i class="bi bi-person-fill"></i>
                        <div class="details" id="userAmount">100 Users</div>
                    </li>
                    <li>
                        <i class="bi bi-file-earmark-music-fill"></i>
                        <div class="details" id="songAmount">100 Songs</div>
                    </li>
                    <li>
                        <i class="bi bi-patch-check-fill"></i>
                        <div class="details" id="famousSongAmount">100 Famous Songs</div>
                    </li>
                </div>
            </div>
            <div class="songs">
                <div class="h4">
                    <h4>All Songs</h4>
                </div>
                <div class="nav">
                    <li>#</li>
                    <li>Title</li>
                    <li>Album</li>
                    <li><i class="bi bi-clock"></i></li>
                    <li><i class="bi bi-suit-heart"></i></li>
                </div>
                <div class="songList" id="hovSong">
                    <!-- <div class="favSongCard">
                        <span class="addIcon"><i class="bi bi-plus-circle-fill"></i></span>
                        <div class="srNo">100</div>
                        <div class="subCard">
                            <div class="imgBox">
                                <img src="" alt="">
                            </div>
                            <div class="dtCard">
                                <div class="songName">
                                    <h5>songNamebdfdddddgfsbhbjhnkjnd<h5>
                                </div>
                                <div class="artistName">
                                    <h5>artistNamjhuhkjnhnndi;hjnkjfndlkdsnzkngdlkne</h5>
                                </div>
                                <div class="iconCard">
                                    <p class="duration">
                                        00:00
                                    </p>
                                    <p class="ratings">
                                        <i class="bi bi-person-fill"></i>
                                        9
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
            <div class="popInput">
                <div class="closeBtn"><i class="bi bi-x"></i></div>
                <h3>Add Songs</h3>
                <form method="post" enctype="multipart/form-data">
                    <div class="uploadThumbnail">
                        <img src="" alt="" id="photo">
                        <label for="name" id="uploadBtn">
                            <input type="file" name="imagee" accept="image/jpg, image/jpeg, image/png" id="filess"
                                required>
                            <i class="bi bi-camera-fill"></i></label>
                    </div>
                    <div class="card">
                        <label for="name">Song Name</label>
                        <input type="text" name="songName" placeholder="Enter the Song Name..." required>
                    </div>
                    <div class="card">
                        <label for="name">Artist Name</label>
                        <input type="text" name="artistName" placeholder="Enter the Song Name..." required>
                    </div>
                    <div class="card">
                        <label for="audio">Choose the song audio file</label>
                        <input type="file" name="audio" accept="audio/mp3" required>
                    </div>
                    <input class="btnSub" type="submit" value="Add" class="submit">
                </form>
            </div>
        </div>

    </header>
    <!-- <script src="app.js"></script> -->

</body>

</html>