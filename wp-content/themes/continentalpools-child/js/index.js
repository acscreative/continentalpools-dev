var paths = document.querySelectorAll('svg path');
paths = Array.prototype.slice.call(paths);
var props = {
  duration: 14000,
  fill: 'both',
  easing: 'ease-in-out',
  iterations: Infinity,
  direction: 'alternate'
}
var players = [3];

players[0] = paths[0].animate([
  {transform: 'translate(-80px, 5px)'},
  {transform: 'translate(80px, 0px)'},
], props);
players[1] = paths[1].animate([
  {transform: 'translate(80px, 10px)'},
  {transform: 'translate(-80px, 0px)'},
], props);
players[2] = paths[2].animate([
  {transform: 'translate(-20px, 0)'},
  {transform: 'translate(-80px, 10px)'},
], props);

players[0].playbackRate = 1.2;
players[2].playbackRate = .82;