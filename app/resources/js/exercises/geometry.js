/** Include endpoints, but exclude points on the line outside the drawn segment. */
export function isOnSegment(start, end, point) {
  return (
    point.x >= Math.min(start.x, end.x) &&
    point.x <= Math.max(start.x, end.x) &&
    point.y >= Math.min(start.y, end.y) &&
    point.y <= Math.max(start.y, end.y) &&
    (point.x - start.x) * (end.y - start.y) === (point.y - start.y) * (end.x - start.x)
  );
}
