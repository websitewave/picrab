#!/bin/bash

# Директория, откуда брать файлы (по умолчанию текущая директория)
DIRECTORY=${1:-.}

# Файл вывода
OUTPUT="output.txt"

# Если файл вывода существует, удаляем его
if [ -f "$OUTPUT" ]; then
    rm "$OUTPUT"
fi

# Получаем имя скрипта (только имя файла)
SCRIPT_NAME=$(basename "$0")

# Используем find для рекурсивного поиска всех файлов, исключая output.txt и сам скрипт
find "$DIRECTORY" -type f ! -name "$SCRIPT_NAME" ! -name "$OUTPUT" -print0 | while IFS= read -r -d '' FILE; do
    echo "----------------------------" >> "$OUTPUT"
    echo "Файл $(realpath --relative-to="$DIRECTORY" "$FILE")" >> "$OUTPUT"
    echo "" >> "$OUTPUT"
    cat "$FILE" >> "$OUTPUT"
    echo "" >> "$OUTPUT"
    echo "----------------------------" >> "$OUTPUT"
done

echo "Содержимое всех файлов сохранено в $OUTPUT"