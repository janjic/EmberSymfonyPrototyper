export default function dragDropEventHasFiles(evt) {
  try {
    return evt.dataTransfer.types.includes('Files');
  } catch(e) {}
  return false;
}
