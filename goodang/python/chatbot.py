import os
import google.generativeai as genai
import tkinter as tk
from tkinter import scrolledtext

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
    system_instruction="You are an AI assistant specifically designed to support warehouse management systems (WMS). This system is intended to efficiently record, monitor, and manage stock items, inbound and outbound transactions, and warehouse data. You must provide advice, guidance, and solutions related to warehouse management based on the user's needs.",
)

chat_session = model.start_chat(history=[])

def send_message():
    user_input = user_entry.get()
    if user_input.strip():
        chat_display.insert(tk.END, f"You: {user_input}\n")
        user_entry.delete(0, tk.END)

        try:
            response = chat_session.send_message(user_input)
            bot_reply = response.text.strip() 
        except Exception as e:
            bot_reply = f"Error: {str(e)}"  

        chat_display.insert(tk.END, f"Chatbot: {bot_reply}\n")
        chat_display.yview(tk.END)

app = tk.Tk()
app.title("Warehouse Management Chatbot")
app.geometry("600x500")
app.configure(bg="#f0f0f0")
chat_display = scrolledtext.ScrolledText(app, wrap=tk.WORD, bg="white", fg="black", font=("Arial", 12))
chat_display.pack(padx=10, pady=10, fill=tk.BOTH, expand=True)
chat_display.config(state=tk.NORMAL)

input_frame = tk.Frame(app, bg="#f0f0f0")
input_frame.pack(padx=10, pady=10, fill=tk.X)

user_entry = tk.Entry(input_frame, font=("Arial", 14))
user_entry.pack(side=tk.LEFT, padx=(0, 10), fill=tk.X, expand=True)

send_button = tk.Button(input_frame, text="Send", font=("Arial", 14), bg="#0078D7", fg="white", command=send_message)
send_button.pack(side=tk.RIGHT)
chat_display.insert(tk.END, "Chatbot: Hello! How can I assist you with warehouse management today?\n")
app.mainloop()
