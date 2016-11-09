export default function humanReadableFileSize(size) {
  let label = "";
  if(Object.is(size, 0)) {
    label = "0 KB";
  } else if(size && !isNaN(size)) {
    var fileSizeInBytes = size;
    var i = -1;
    do {
      fileSizeInBytes = fileSizeInBytes / 1024;
      i++;
    } while (fileSizeInBytes > 1024);

    var byteUnits = [' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB'];
    label += Math.max(fileSizeInBytes, 0.1).toFixed(1) + byteUnits[i];
  }
  return label;
}
