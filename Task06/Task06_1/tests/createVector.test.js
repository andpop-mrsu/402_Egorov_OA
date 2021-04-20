import createVector from '../src/index'

test('toString', () => {
  expect(createVector(-1, 20, 3).toString()).toBe('(-1;20;3)')
})

test('getLength', () => {
  expect(createVector(-1, 2, 2).getLength()).toBe(3)
})

test('add', () => {
  const vector1 = createVector(3, 5, 9)
  const vector2 = createVector(1, 2, 0)
  expect(vector1.add(vector2).toString()).toBe('(4;7;9)')
})

test('sub', () => {
  const vector1 = createVector(3, 5, 9)
  const vector2 = createVector(1, 2, 0)
  expect(vector1.sub(vector2).toString()).toBe('(2;3;9)')
})

test('product', () => {
  expect(createVector(1, 9, -3).product(3).toString()).toBe('(3;27;-9)')
})

test('scalarProduct', () => {
  const vector1 = createVector(1, -5, 2)
  const vector2 = createVector(10, 3, 0)
  expect(vector1.scalarProduct(vector2)).toBe(-5)
})

test('vectorProduct', () => {
  const vector1 = createVector(9, 1, -5)
  const vector2 = createVector(0, -1, 2)
  expect(vector1.vectorProduct(vector2).toString()).toBe('(-3;-18;-9)')
})