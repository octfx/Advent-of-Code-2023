import math
import re
import sys


def read_file(path: str) -> list[list, list]:
    """Parse the times and distances in a list of pairs
    """
    times = []
    distances = []

    with open(path, 'r') as fp:
        for i, line in enumerate(fp):
            parts = line.split(':')

            if puzzle2:
                parts[1] = re.sub(r'\s+', '', parts[1])

            if parts[0] == 'Time':
                times = re.split(r'\s+', parts[1].strip())
            else:
                distances = re.split(r'\s+', parts[1].strip())

    return zip([int(time) for time in times], [int(distance) for distance in distances])


def solve(run: list) -> int:
    """The solution can be found by solving the in-equation of the form
    time * x - x^2 > distance
    Where x is the time the button was held down
    which directly corresponds to the distance traveled per second in the remaining time

    Alternatively we can solve for the distance (+ some margin) and calculate the number of integer steps between x2 and x1
    """
    time, distance = run
    a = -1
    b = time
    c = -distance-0.1

    # Calculate the discriminant
    discriminant = time ** 2 - 4 * time * c

    # Check if the discriminant is non-negative
    if discriminant >= 0:
        # Calculate the two solutions using the quadratic formula
        x1 = ((-b + math.sqrt(b**2-4*a*c))/2*a)
        x2 = ((-b - math.sqrt(b**2-4*a*c))/2*a)

        return int(x2)-int(x1)
    else:
        return 0


if __name__ == '__main__':
    puzzle2 = len(sys.argv) == 3 and sys.argv[2] == 'Puzzle2'

    if len(sys.argv) > 1:
        file = sys.argv[1]
    elif len(sys.argv) == 1:
        file = './input.txt'

    pairs = read_file(file)

    out_prod = 1

    for pair in pairs:
        out_prod *= solve(pair)

    print(f'Answer: {out_prod}')
