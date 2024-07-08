var dislike = document.querySelector(".bi-hand-thumbs-down");
dislike.addEventListener('click', function () {
    dislike.classList.toggle("bi-hand-thumbs-down-fill");
    dislike.classList.toggle("bi-hand-thumbs-down");
    console.log(dislike);
});

var like = document.querySelector(".likeicon");
like.addEventListener('click', function () {
    var postID = event.target.id;
    var isselect = (like.classList.contains("bi-hand-thumbs-up-fill")) ? true : false;
    $.ajax({
        url: "viewPost.php", // 呼叫的PHP檔案名稱
        type: "POST", // 呼叫的HTTP方法
        data: { 'postID': postID, 'TF': isselect }, // postID為貼文id，TF是否有點讚(true該貼文已點讚，反之沒有)
    });
    like.classList.toggle("bi-hand-thumbs-up-fill");
    like.classList.toggle("bi-hand-thumbs-up");
    console.log(like);
});