import tkinter as tk
from tkinter import ttk, messagebox
import requests

# Fungsi untuk mengambil data dari API
def get_barang():
    fetch_data("http://127.0.0.1:8000/api/barangs", "Barang")

def get_kategori():
    fetch_data("http://127.0.0.1:8000/api/kategoris", "Kategori")

def get_supplier():
    fetch_data("http://127.0.0.1:8000/api/suppliers", "Supplier")

def fetch_data(url, title):
    try:
        response = requests.get(url)
        if response.status_code == 200:
            data = response.json()
            display_data(data, title)
        else:
            messagebox.showerror("Error", f"Gagal mengambil data {title.lower()}: {response.status_code}")
    except requests.exceptions.RequestException as e:
        messagebox.showerror("Error", f"Tidak dapat terhubung ke API: {e}")

def display_data(data, title):
    display_window = tk.Toplevel(root)
    display_window.title(f"Data {title}")
    display_window.geometry("600x400")
    display_window.config(bg="#f0f8ff")  

    tree = ttk.Treeview(display_window, columns=list(data[0].keys()), show="headings", height=15)
    tree.pack(expand=True, fill="both", pady=10, padx=10)

    for column in data[0].keys():
        tree.heading(column, text=column)
        tree.column(column, width=150)

    for item in data:
        tree.insert("", "end", values=list(item.values()))


root = tk.Tk()
root.title("Aplikasi API Goodang")
root.geometry("400x300")
root.config(bg="#4682b4")  # btn warna biru

style = ttk.Style()
style.configure("TButton",
                font=("Arial", 12),
                padding=10,
                background="#87ceeb",
                foreground="black")
style.map("TButton", background=[("active", "#5f9ea0")])
title_label = tk.Label(root, text="Aplikasi API Goodang", font=("Arial", 16, "bold"), bg="#4682b4", fg="white")
title_label.pack(pady=20)

btn_barang = ttk.Button(root, text="Lihat Data Barang", command=get_barang)
btn_barang.pack(pady=10)

btn_kategori = ttk.Button(root, text="Lihat Data Kategori", command=get_kategori)
btn_kategori.pack(pady=10)

btn_supplier = ttk.Button(root, text="Lihat Data Supplier", command=get_supplier)
btn_supplier.pack(pady=10)

root.mainloop()
