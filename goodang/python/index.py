import os
import tkinter as tk
from tkinter import ttk, messagebox
import requests
import google.generativeai as genai

# Konfigurasi Google Generative AI
genai.configure(api_key="AIzaSyCC_CaHgYnsSe63Or_d7UaOBZCd4qTJM8A")

generation_config = {
    "temperature": 1,
    "top_p": 0.95,
    "top_k": 40,
    "max_output_tokens": 8192,
    "response_mime_type": "text/plain",
}

model = genai.GenerativeModel(
    model_name="gemini-2.0-flash-exp",
    generation_config=generation_config,
    system_instruction="You are an AI assistant specialized in warehouse management systems.",
)

chat_session = model.start_chat(history=[])

BASE_URL = "http://127.0.0.1:8000/api"

def fetch_data(endpoint):
    try:
        response = requests.get(f"{BASE_URL}/{endpoint}")
        response.raise_for_status()
        return response.json()
    except requests.exceptions.RequestException as e:
        messagebox.showerror("Error", f"Failed to fetch {endpoint}: {e}")
        return []

def copy_to_clipboard(text):
    app.clipboard_clear()
    app.clipboard_append(text)
    app.update()
    messagebox.showinfo("Copied", "Text copied to clipboard!")

def display_message(sender, message):
    msg_frame = tk.Frame(chat_display_inner, bg="#f8f9fa")

    if sender == "user":
        msg_label = tk.Label(
            msg_frame,
            text=message,
            bg="#1e88e5",
            fg="white",
            font=("Poppins", 12),
            wraplength=500,
            justify="left",
            padx=10,
            pady=5,
        )
        msg_label.pack(anchor="e", pady=5, padx=10)
    elif sender == "bot":
        msg_label = tk.Label(
            msg_frame,
            text=message,
            bg="#e9ecef",
            fg="black",
            font=("Poppins", 12),
            wraplength=500,
            justify="left",
            padx=10,
            pady=5,
        )
        msg_label.pack(anchor="w", pady=5, padx=10)

    copy_button = tk.Button(
        msg_frame,
        text="Copy",
        font=("Poppins", 10),
        bg="#6c757d",
        fg="white",
        command=lambda: copy_to_clipboard(message),
        relief="flat"
    )
    copy_button.pack(anchor="e" if sender == "user" else "w", padx=5, pady=5)

    msg_frame.pack(fill="x", anchor="w", pady=5)
    chat_display_canvas.update_idletasks()
    chat_display_canvas.yview_moveto(1)

def pilih_barang():
    barang_data = fetch_data("barangs")
    if not barang_data:
        messagebox.showerror("Error", "No barang data found.")
        return

    def on_select_item():
        try:
            selected_item = tree.focus()
            if not selected_item:
                messagebox.showwarning("Warning", "No item selected.")
                return

            item_data = tree.item(selected_item)["values"]
            barang_name, kategori_name, supplier_name = item_data

            user_prompt = f"""
            Barang: {barang_name}
            Kategori: {kategori_name}
            Supplier: {supplier_name}
            Berikan deskripsi lengkap untuk sisi produsen (bukan promosi) dan kreatif tapi tidak terlalu panjang untuk produk ini.
            """
            response = chat_session.send_message(user_prompt)
            bot_reply = response.text.strip()
            display_message("bot", bot_reply)
            select_window.destroy()

        except Exception as e:
            messagebox.showerror("Error", f"Failed to process selection: {e}")

    select_window = tk.Toplevel(app)
    select_window.title("Pilih Barang")
    select_window.geometry("600x400")
    select_window.config(bg="#f8f9fa")

    tree = ttk.Treeview(select_window, columns=("Nama", "Kategori", "Supplier"), show="headings", height=15)
    tree.pack(expand=True, fill="both", pady=10, padx=10)

    tree.heading("Nama", text="Nama Barang")
    tree.heading("Kategori", text="Kategori")
    tree.heading("Supplier", text="Supplier")

    for barang in barang_data:
        barang_name = barang.get("nama", "Unknown")
        kategori_name = barang.get("kategori", {}).get("nama", "Unknown")
        supplier_name = barang.get("supplier", {}).get("nama", "Unknown")
        tree.insert("", "end", values=(barang_name, kategori_name, supplier_name))

    select_button = tk.Button(select_window, text="Konfirmasi", font=("Poppins", 12), bg="#1e88e5", fg="white", command=on_select_item)
    select_button.pack(pady=10)

def send_message():
    user_input = user_entry.get()
    if user_input.strip():
        display_message("user", user_input)
        user_entry.delete(0, tk.END)

        try:
            response = chat_session.send_message(user_input)
            bot_reply = response.text.strip()
        except Exception as e:
            bot_reply = f"Error: {str(e)}"

        display_message("bot", bot_reply)

suggestions_pool = [
    "Apa nama gudang yang cocok untuk lokasi di pusat kota?",
    "Bagaimana cara mengatur sistem inventaris untuk gudang kecil?",
    "Berapa biaya rata-rata untuk membangun gudang baru?",
    "Bagaimana cara meningkatkan efisiensi penyimpanan di gudang besar?",
    "Apa saja teknologi terbaru untuk manajemen gudang?",
    "Bagaimana cara memilih lokasi gudang strategis?",
    "Berapa kapasitas optimal untuk gudang kecil?",
    "Apa kelebihan dan kekurangan sistem gudang otomatis?",
    "Bagaimana cara mengelola stok barang yang cepat rusak?",
    "Apa saja faktor penting dalam desain tata letak gudang?",
    "Bagaimana cara melatih karyawan untuk manajemen gudang?",
    "Apa perbedaan antara WMS dan ERP dalam manajemen gudang?",
    "Bagaimana cara menghitung ROI dari sistem otomatisasi gudang?",
    "Apa saja risiko dalam manajemen gudang dan cara mengatasinya?",
    "Bagaimana cara mengelola inventaris musiman di gudang?",
]

current_suggestions = suggestions_pool[:2]

def refresh_suggestions():
    global current_suggestions
    suggestions_pool.extend(current_suggestions)
    current_suggestions = [suggestions_pool.pop(0) for _ in range(2)]
    update_suggestion_buttons()

def fill_with_suggestion(suggestion):
    user_entry.delete(0, tk.END)
    user_entry.insert(0, suggestion)
    refresh_suggestions()

def update_suggestion_buttons():
    # Remove only suggestion buttons
    for widget in toolbar_frame.winfo_children():
        if getattr(widget, "is_suggestion", False):  # Identify suggestion buttons
            widget.destroy()

    # Add updated suggestion buttons
    for suggestion in current_suggestions:
        suggestion_button = tk.Button(
            toolbar_frame,
            text=suggestion,
            font=("Poppins", 10),
            bg="#1e88e5",
            fg="white",
            command=lambda s=suggestion: fill_with_suggestion(s),
            wraplength=200,
            justify="left",
            relief="flat",
            anchor="w",
        )
        suggestion_button.is_suggestion = True  # Mark as a suggestion button
        suggestion_button.pack(side="left", padx=5, anchor="w")


app = tk.Tk()
app.title("Goodang Chatbot")
app.geometry("600x400")
app.configure(bg="#f8f9fa")

chat_display_frame = tk.Frame(app, bg="#f8f9fa")
chat_display_canvas = tk.Canvas(chat_display_frame, bg="#f8f9fa")
scrollbar = ttk.Scrollbar(chat_display_frame, orient="vertical", command=chat_display_canvas.yview)
chat_display_inner = tk.Frame(chat_display_canvas, bg="#f8f9fa")

chat_display_inner.bind(
    "<Configure>",
    lambda e: chat_display_canvas.configure(scrollregion=chat_display_canvas.bbox("all")),
)

chat_display_canvas.create_window((0, 0), window=chat_display_inner, anchor="nw")
chat_display_canvas.configure(yscrollcommand=scrollbar.set)

chat_display_canvas.pack(side="left", fill="both", expand=True)
scrollbar.pack(side="right", fill="y")
chat_display_frame.pack(fill="both", expand=True, padx=10, pady=10)

input_frame = tk.Frame(app, bg="#f8f9fa")
input_frame.pack(padx=10, pady=10, fill="x")

user_entry = tk.Entry(input_frame, font=("Poppins", 14))
user_entry.pack(side="left", padx=(0, 10), fill="x", expand=True)

send_button = tk.Button(input_frame, text="Send", font=("Poppins", 14), bg="#1e88e5", fg="white", command=send_message)
send_button.pack(side="right")

toolbar_frame = tk.Frame(app, bg="#f8f9fa")
toolbar_frame.pack(pady=10)

update_suggestion_buttons()

select_item_button = tk.Button(toolbar_frame, text="Generate Deskripsi", font=("Poppins", 12), bg="#1e88e5", fg="white", command=pilih_barang)
select_item_button.pack(side="left", padx=(0, 10))

app.mainloop()

