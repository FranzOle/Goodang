import random
import string

def generate_random_number(length=None):
    if length is None:
        length = random.randint(8, 12)
    return ''.join(random.choices(string.digits, k=length))

def generate_code(prefix, length=None):
    random_number = generate_random_number(length)
    return f"{prefix}-{random_number}"

def main():
    while True:
        print("\nPilih tipe kode yang ingin Anda buat:")
        print("1. Barang (Kode SKU)")
        print("2. Transaksi")
        print("3. Custom")
        print("4. Keluar")

        choice = input("Masukkan pilihan (1/2/3/4): ").strip()

        if choice == '1':
            prefix = "BRG"
            print("Membuat kode untuk Barang (SKU)...")
        elif choice == '2':
            prefix = "TRX"
            print("Membuat kode untuk Transaksi...")
        elif choice == '3':
            prefix = input("Masukkan prefix kustom untuk kode: ").strip().upper()
            print(f"Membuat kode dengan prefix kustom: {prefix}...")
        elif choice == '4':
            print("Terima kasih telah menggunakan program!")
            break
        else:
            print("Pilihan tidak valid. Silakan coba lagi.")
            continue

        code = generate_code(prefix)
        print(f"Kode yang dihasilkan: {code}")

if __name__ == "__main__":
    main()
