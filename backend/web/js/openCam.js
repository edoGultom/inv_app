const controls = document.querySelector(".controls");
// const cameraOptions = document.querySelector(".video-options>select");
const video = document.querySelector("#video");
const canvas = document.getElementById("canvas");
const screenshotImage = document.querySelector(".screenshot-image");
const buttons = [...controls.querySelectorAll("button")];
const btnSave = document.querySelector(".btnSave");
const loading = document.querySelector(".loading");
let streamStarted = false;

const [screenshot] = buttons;

$(".modal-header").remove();

const getCameraSelection = async () => {
  const devices = await navigator.mediaDevices.enumerateDevices();

  const videoDevices = devices.filter((device) => device.kind === "videoinput");
  console.log(videoDevices);

  const options = videoDevices.map((videoDevice) => {
    return `<option value="${videoDevice.deviceId}">${videoDevice.label}</option>`;
  });

  cameraOptions.innerHTML = options.join("");
};

const constraints = {
  audio: false,
  video: {
    width: 475,
    height: 475,
  },
};

// cameraOptions.onchange = () => {
//   const updatedConstraints = {
//     ...constraints,
//     deviceId: {
//       exact: cameraOptions.value,
//     },
//   };

//   startStream(updatedConstraints);
// };

const startStream = async (constraints) => {
  const stream = await navigator.mediaDevices.getUserMedia(constraints);
  handleStream(stream);
};

const handleStream = (stream) => {
  loading.classList.add("d-none");
  video.srcObject = stream;
  screenshot.classList.remove("d-none");
  video.classList.remove("d-none");
};
// getCameraSelection();

if ("mediaDevices" in navigator && navigator.mediaDevices.getUserMedia) {
  const updatedConstraints = {
    ...constraints,
    // deviceId: {
    //   exact: cameraOptions.value,
    // },
  };
  startStream(updatedConstraints);
}

const doScreenshot = () => {
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const context = canvas.getContext("2d");
  context.drawImage(video, 0, 0);

  screenshotImage.src = canvas.toDataURL("image/webp");
  screenshotImage.classList.remove("d-none");
  $(".screenshot > span").text("Ambil Ulang");
};

screenshot.onclick = doScreenshot;

$("#ajaxCrudModal").on("hidden.bs.modal", function () {
  $.pjax.reload({ container: "#open-cam-pjax", timeout: false, async: false });
});

$("body").on("click", ".btnSave", function (e) {
  const sumber = canvas.getAttribute("data-sumber");
  const destinationCanvas = document.createElement("canvas");
  const destCtx = destinationCanvas.getContext("2d");

  destinationCanvas.height = 500;
  destinationCanvas.width = 500;

  destCtx.translate(video.videoWidth, 0);
  destCtx.scale(-1, 1);
  destCtx.drawImage(document.getElementById("canvas"), 0, 0);

  let imagebase64data = destinationCanvas.toDataURL("image/png");
  imagebase64data = imagebase64data.replace("data:image/png;base64,", "");

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const id_aktivitas = urlParams.get("id_aktivitas");

  $.ajax({
    type: "POST",
    url:
      "/aktivitas-harian/open-camera?id_aktivitas=" +
      id_aktivitas +
      "&sumber=" +
      sumber,
    data: {
      imageData: imagebase64data,
      ext: "png",
    },
    success: function (status) {
      if (status) {
        $("#ajaxCrudModal").modal("hide");
      }
    },
    error: function (err) {
      console.log(err);
    },
  });
});
