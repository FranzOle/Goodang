import requests
from tkinter import messagebox

class APIManager:
    BASE_URL = "http://127.0.0.1:8000/api"

    @staticmethod
    def fetch_data(endpoint):
        try:
            response = requests.get(f"{APIManager.BASE_URL}/{endpoint}")
            if response.status_code == 200:
                return response.json()
            else:
                raise ValueError(f"Gagal mengambil data: {response.status_code}")
        except requests.exceptions.RequestException as e:
            raise ValueError(f"Tidak dapat terhubung ke API: {e}")
