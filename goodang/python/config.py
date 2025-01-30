import os
import google.generativeai as genai

genai.configure(api_key="GEMINI_API_KEY")

generation_config = {
  "temperature": 1,
  "top_p": 0.95,
  "top_k": 40,
  "max_output_tokens": 8192,
  "response_mime_type": "application/json",
}

model = genai.GenerativeModel(
  model_name="gemini-2.0-flash-exp",
  generation_config=generation_config,
  system_instruction="You are an AI assistant specifically designed to support warehouse management systems (WMS). This system is intended to efficiently record, monitor, and manage stock items, inbound and outbound transactions, and warehouse data. You must provide advice, guidance, and solutions related to warehouse management based on the user's needs.",
)

chat_session = model.start_chat(
  history=[
  ]
)

response = chat_session.send_message("Hello")

print(response.text)