from datetime import datetime
from pathlib import Path

import mysql.connector
import pandas as pd

csv_path = Path(__file__).with_name("sample-data.csv")
df = pd.read_csv(csv_path)

connection = mysql.connector.connect(
    host="127.0.0.1",
    port=3306,
    user="root",
    password="",
    database="warmtedashboard",
)
cursor = connection.cursor()

now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
sql = """
    INSERT INTO people (
        id, name, email, city, country, signup_date, amount, created_at, updated_at
    )
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
    ON DUPLICATE KEY UPDATE
        name = VALUES(name),
        email = VALUES(email),
        city = VALUES(city),
        country = VALUES(country),
        signup_date = VALUES(signup_date),
        amount = VALUES(amount),
        updated_at = VALUES(updated_at)
"""
rows = [
    ( 
        int(row["id"]),
        str(row["name"]),
        str(row["email"]),
        str(row["city"]),
        str(row["country"]),
        str(row["signup_date"]),
        float(row["amount"]),
        now,
        now,
    )
    for _, row in df.iterrows()
]

cursor.executemany(sql, rows)
connection.commit()

print(f"Imported {len(rows)} people from {csv_path.name}")

cursor.close()
connection.close()
