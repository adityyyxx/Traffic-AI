# Use slim Python image
FROM python:3.10-slim

# Prevent interactive prompts during install
ENV DEBIAN_FRONTEND=noninteractive

# Create app directory
WORKDIR /app

# Copy all project files
COPY . /app

# Install required Python packages
RUN pip install --no-cache-dir -r requirements.txt

# Make sure 'uploads' folder exists
RUN mkdir -p uploads

# Expose port for Render (Render sets PORT env var)
EXPOSE 8080

# Start the Flask app
CMD ["python", "detect.py"]
