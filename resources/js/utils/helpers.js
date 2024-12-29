const share = function () {
    function popupCenter(url, title, width, height) {
        let popupWidth = width || 640
        let popupHeight = height || 440
        let windowLeft = window.screenLeft || window.screenX
        let windowTop = window.screenTop || window.screenY
        let windowWidth = window.innerWidth || document.documentElement.clientWidth
        let windowHeight = window.innerHeight || document.documentElement.clientHeight
        let popupLeft = windowLeft + windowWidth / 2 - popupWidth / 2
        let popupTop = windowTop + windowHeight / 2 - popupHeight / 2
        window.open(
            url,
            title,
            'scrollbars=yes, width=' +
                popupWidth +
                ', height=' +
                popupHeight +
                ', top=' +
                popupTop +
                ', left=' +
                popupLeft,
        )
    }

    let twitter = document.querySelector('.share_twitter')
    if (twitter) {
        twitter.addEventListener('click', function (e) {
            e.preventDefault()
            let url = this.getAttribute('data-url')
            let shareUrl =
                'https://twitter.com/intent/tweet?text=' +
                encodeURIComponent(document.title) +
                '&via=laravelcd' +
                '&url=' +
                encodeURIComponent(url)
            popupCenter(shareUrl, 'Partager sur Twitter')
        })
    }

    let facebook = document.querySelector('.share_facebook')
    if (facebook) {
        facebook.addEventListener('click', function (e) {
            e.preventDefault()
            let url = this.getAttribute('data-url')
            let shareUrl = 'https://facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url)
            popupCenter(shareUrl, 'Partager sur Facebook')
        })
    }

    let linkedin = document.querySelector('.share_linkedin')
    if (linkedin) {
        linkedin.addEventListener('click', function (e) {
            e.preventDefault()
            let url = this.getAttribute('data-url')
            let shareUrl = 'https://www.linkedin.com/shareArticle?url=' + encodeURIComponent(url)
            popupCenter(shareUrl, 'Partager sur LinkedIn')
        })
    }
}

share()
