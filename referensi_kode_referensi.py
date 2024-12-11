import random

# Generate 100 random numbers, each with 9 digits
random_numbers = [random.randint(100000000, 999999999) for _ in range(100)]


print(random_numbers)