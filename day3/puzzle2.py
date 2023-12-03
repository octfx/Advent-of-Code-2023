import math
import re


def read_file(path: str) -> list[list, list]:
    """Parse each line of the input to retrieve numbers and their start/end positions
    as well as the position of all gears.

    Numbers are saved as tuples in the following form: (line, start, end, number)
    Symbols are saved in the form of: (line, start, symbol)
    """
    nums = []
    gears = []

    with open(path, 'r') as fp:
        for i, line in enumerate(fp):
            for m in re.finditer(r'(\d+|\*)', line):
                if re.match(r'\d', m.group()):
                    nums.append((i, m.start(), m.end() - 1, m.group()))
                else:
                    gears.append((i, m.start(), m.group()))

    return [gears, nums]


def calc_ratio_for_gear(symbol: tuple, numbers: list) -> int:
    """Find all numbers in the vicinity of a gear and calculate its ratio."""
    line, pos, symbol = symbol

    matches = [
        number for number in numbers
        # Search the current line, above, below
        if (number[0] == line or number[0] == line - 1 or number[0] == line + 1) and
           # Test if the symbol position matches the start/end of a number
           (
               # In between start and End
               (number[1] <= pos <= number[2]) or
               # Start to right
               (pos + 1 == number[1]) or
               # End to left
               (pos - 1 == number[2])
           )
    ]

    # Ignore gears that do not have exactly two numbers adjacent to them
    if len(matches) != 2:
        return 0

    return math.prod([int(num[3]) for num in matches])


if __name__ == '__main__':
    symbols, numbers = read_file('./input.txt')

    out_sum = sum([calc_ratio_for_gear(symbol, numbers) for symbol in symbols])

    print(f'Answer: {out_sum}')
