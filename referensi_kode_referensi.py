import random
import string
import tkinter as tk
from tkinter import messagebox

def generate_random_number(length=None):
    if length is None:
        length = random.randint(8, 12)
    return ''.join(random.choices(string.digits, k=length))

def generate_code(prefix, length=None):
    random_number = generate_random_number(length)
    return f"{prefix}-{random_number}"

def generate_and_display_code():
    selected_type = type_var.get()

    if selected_type == "SKU Barang":
        prefix = "BRG"
    elif selected_type == "Transaksi":
        prefix = "TRX"
    elif selected_type == "Custom":
        prefix = prefix_var.get().strip().upper()
        if not prefix:
            messagebox.showwarning("Peringatan", "Prefix untuk Custom tidak boleh kosong!")
            return
    else:
        messagebox.showwarning("Peringatan", "Pilih tipe kode yang valid!")
        return

    code = generate_code(prefix)
    code_var.set(code)

def copy_to_clipboard():
    code = code_var.get()
    if code:
        root.clipboard_clear()
        root.clipboard_append(code)
        root.update() 
        messagebox.showinfo("Info", "Kode berhasil disalin ke clipboard!")
    else:
        messagebox.showwarning("Peringatan", "Tidak ada kode untuk disalin!")

# GUI setup
root = tk.Tk()
root.title("Kode Generator")
root.geometry("400x300")
root.resizable(False, False)

# Input Frame
input_frame = tk.Frame(root, padx=10, pady=10)
input_frame.pack(fill="x")

type_label = tk.Label(input_frame, text="Pilih Tipe Kode:")
type_label.pack(anchor="w")

type_var = tk.StringVar(value="SKU Barang")

types = ["SKU Barang", "Transaksi", "Custom"]
for t in types:
    tk.Radiobutton(input_frame, text=t, variable=type_var, value=t).pack(anchor="w")

prefix_label = tk.Label(input_frame, text="Prefix (Untuk Custom):")
prefix_label.pack(anchor="w")

prefix_var = tk.StringVar()
prefix_entry = tk.Entry(input_frame, textvariable=prefix_var, width=20)
prefix_entry.pack(fill="x", expand=True, padx=(0, 10))

generate_button = tk.Button(input_frame, text="Generate", command=generate_and_display_code)
generate_button.pack(pady=5)

# Output Frame
output_frame = tk.Frame(root, padx=10, pady=10)
output_frame.pack(fill="x")

code_label = tk.Label(output_frame, text="Kode yang Dihasilkan:")
code_label.pack(anchor="w")

code_var = tk.StringVar()
code_display = tk.Entry(output_frame, textvariable=code_var, state="readonly", width=30, font=("Helvetica", 12))
code_display.pack(fill="x", padx=(0, 10))

copy_button = tk.Button(output_frame, text="Copy", command=copy_to_clipboard)
copy_button.pack(pady=10)

root.mainloop()
