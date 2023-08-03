const video = document.querySelector("#video");

// Basic settings for the video to get from Webcam
const constraints = {
  audio: false,
  video: {
    width: 475,
    height: 475,
  },
};

// This condition will ask permission to user for Webcam access
if (navigator.mediaDevices.getUserMedia) {
  navigator.mediaDevices
    .getUserMedia(constraints)
    .then(function (stream) {
      video.srcObject = stream;
    })
    .catch(function (err0r) {
      console.log("Something went wrong!");
    });
}

function stop(e) {
  const stream = video.srcObject;
  const tracks = stream.getTracks();

  for (let i = 0; i < tracks.length; i++) {
    const track = tracks[i];
    track.stop();
  }
  video.srcObject = null;
}

// Below code to capture image from Video tag (Webcam streaming)
const btnCapture = document.querySelector("#btnCapture");
const canvas = document.getElementById("canvas");

btnCapture.addEventListener("click", function () {
  const context = canvas.getContext("2d");
  // Capture the image into canvas from Webcam streaming Video element
  context.drawImage(video, 0, 0);
});

// Upload image to server - ajax call - with the help of base64 data as a parameter
const btnSave = document.querySelector("#btnSave");

btnSave.addEventListener("click", async function () {
  // Below new canvas to generate flip/mirror image from existing canvas
  const destinationCanvas = document.createElement("canvas");
  const destCtx = destinationCanvas.getContext("2d");

  destinationCanvas.height = 500;
  destinationCanvas.width = 500;

  destCtx.translate(video.videoWidth, 0);
  destCtx.scale(-1, 1);
  destCtx.drawImage(document.getElementById("canvas"), 0, 0);

  // Get base64 data to send to server for upload
  let imagebase64data = destinationCanvas.toDataURL("image/png");
  imagebase64data = imagebase64data.replace("data:image/png;base64,", "");
  console.log(imagebase64data);
  $.ajax({
    type: "POST",
    url: "/aktivitas-harian/open-camera",
    data: {
      imageData: imagebase64data,
    },
    success: function (isi) {
      console.log(isi);
    },
    error: function (err) {
      console.log(err);
    },
  });
  // try {
  //   const response = await fetch("/Home/UploadWebCamImage", {
  //     method: "POST",
  //     headers: {
  //       "Content-Type": "application/json; charset=utf-8",
  //     },
  //     body: JSON.stringify({
  //       imageData: imagebase64data,
  //     }),
  //   });

  //   if (response.ok) {
  //     alert("Image uploaded successfully..");
  //   } else {
  //     throw new Error(`Request failed with status ${response.status}`);
  //   }
  // } catch (error) {
  //   console.error("Error while uploading image:", error);
  // }
});
