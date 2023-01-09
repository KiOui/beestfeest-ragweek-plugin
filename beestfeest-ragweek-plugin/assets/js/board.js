function donationsListMakeHTML(jsondata) {
    let ul = document.createElement('ul');
    for (let idx = 0; idx < jsondata.length; idx++) {
        let line = jsondata[idx]['title']['rendered'];
        let price = parseFloat(jsondata[idx]['bfrw_requested_song_price']).toFixed(2);
        if (line === '') continue;
        let li = document.createElement('li');
        li.innerText = line + " - € " + price;
        ul.appendChild(li);
    }
    return ul.innerHTML;
}

function messagesListMakeHTML(jsondata) {
    if (jsondata.length > 0) {
        let retvalue = jsondata[0]['title']['rendered'];
        for (let i = 1; i < jsondata.length; i++) {
            retvalue += " - " + jsondata[i]['title']['rendered'];
        }
        return retvalue;
    }
    else {
        return "";
    }
}

function decodeHtml(html) {
    let txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

function refresh_data() {
    const fetchSongs = fetch('/wp-json/wp/v2/bfrw_requested_songs')
        .then(result => result.json())
        .then(data => data.filter(function(song) {
            return song.status === "publish";
        }))
        .then(data => {
            return data.sort(function(song1, song2) {
                return parseFloat(song1.bfrw_requested_song_price)-parseFloat(song2.bfrw_requested_song_price);
            });
        })
        .then(data => {
            return data.reverse();
        })
        .then(data => {
            let list = donationsListMakeHTML(data);

            let elem = document.getElementById("songs");
            if (elem.innerHTML !== list) {
                elem.innerHTML = decodeHtml(list);
            }

        });
    const fetchNotifications = fetch('/wp-json/wp/v2/bfrw_notifications')
        .then(result => result.json())
        .then(data => data.filter(function(notification) {
            return notification.status === "publish";
        }))
        .then(data => {
            let list = messagesListMakeHTML(data);

            let elem = document.getElementById("scroller");
            if (elem.innerHTML !== list) {
                elem.innerHTML = decodeHtml(list);
            }

        });
    Promise.all([
        fetchSongs,
        fetchNotifications
    ]).finally(() => {
            setTimeout(refresh_data, 5000);
    });
}

refresh_data();