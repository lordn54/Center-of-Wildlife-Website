// (C) 2000 www.CodeLifter.com
// http://www.codelifter.com
// Free for all users, but leave in this  header
// NS4-6,IE4-6
// Fade effect only in IE; degrades gracefully
// =======================================
// set the following variables
// =======================================


// Set slideShowSpeed (milliseconds)
var slideShowSpeed = 5000


// Duration of crossfade (seconds)
var crossFadeDuration = 5


// Specify the image files
var Pic = new Array() // don't touch this
// to add more images, just continue
// the pattern, adding to the array below

// Even indexes are db students, odd indexes are pr students
Pic[0] = 'pics/side_view.gif'
Pic[1] = 'pics/mesaba1.jpg'
Pic[2] = 'pics/Delta5.jpg'
Pic[3] = 'pics/Delta8.jpg'
Pic[4] = 'pics/Delta9.jpg'
Pic[5] = 'pics/aztec-1.jpg'
Pic[6] = 'pics/news-4-2001-2.jpg'
// =======================================
// do not edit anything below this line
// =======================================
var t
var j = 0
var p = Pic.length
var preLoad = new Array()


for (i = 0; i < p; i++){
preLoad[i] = new Image()
preLoad[i].src = Pic[i]
}


function runSlideShow(){
if (document.all){
document.images.SlideShow.style.filter="blendTrans(duration=8)"
document.images.SlideShow.style.filter="blendTrans(duration=crossFadeDuration)"

document.images.SlideShow.filters.blendTrans.Apply()
}
document.images.SlideShow.src = preLoad[j].src
if (document.all){
document.images.SlideShow.filters.blendTrans.Play()
}
j = j + 1
if (j > (p-1)) j=0
t = setTimeout('runSlideShow()', slideShowSpeed)
}

