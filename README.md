### **📌 API Documentation: Laravel 11 Backend for React Frontend**
This **API documentation** will help your frontend developer integrate the **Laravel 11 API** with the React frontend.

---

## **🔑 Authentication API (User Management)**
These endpoints allow user **registration, login, and logout**.

### **1️⃣ Register a User**
📌 **Endpoint:** `POST /api/register`  
🔹 **Headers:**
```json
{
    "Accept": "application/json"
}
```
🔹 **Request Body (JSON - raw):**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
}
```
🔹 **Response:**
```json
{
    "token": "your_generated_token_here"
}
```
✅ **Save the token** for authentication.

---

### **2️⃣ Login User**
📌 **Endpoint:** `POST /api/login`  
🔹 **Headers:**
```json
{
    "Accept": "application/json"
}
```
🔹 **Request Body (JSON - raw):**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```
🔹 **Response:**
```json
{
    "token": "your_generated_token_here"
}
```
✅ **Use the token for authenticated API requests.**

---

### **3️⃣ Logout User**
📌 **Endpoint:** `POST /api/logout`  
🔹 **Headers:**
```json
{
    "Accept": "application/json",
    "Authorization": "Bearer your_token_here"
}
```
🔹 **Response:**
```json
{
    "message": "Logged out"
}
```

---

## **📝 Task Management API (CRUD Operations)**
### **4️⃣ Get All Tasks**
📌 **Endpoint:** `GET /api/tasks`  
🔹 **Headers:**
```json
{
    "Accept": "application/json",
    "Authorization": "Bearer your_token_here"
}
```
🔹 **Response:**
```json
[
    {
        "id": 1,
        "title": "My First Task",
        "description": "This is a test task",
        "status": "pending",
        "file_path": "files/document.pdf",
        "image_path": "images/photo.jpg"
    }
]
```

---

### **5️⃣ Get a Single Task**
📌 **Endpoint:** `GET /api/tasks/{id}`  
🔹 **Headers:**
```json
{
    "Accept": "application/json",
    "Authorization": "Bearer your_token_here"
}
```
🔹 **Response:**
```json
{
    "id": 1,
    "title": "My First Task",
    "description": "This is a test task",
    "status": "pending",
    "file_path": "files/document.pdf",
    "image_path": "images/photo.jpg"
}
```

---

### **6️⃣ Create a New Task**
📌 **Endpoint:** `POST /api/tasks`  
🔹 **Headers:**
```json
{
    "Accept": "application/json",
    "Authorization": "Bearer your_token_here"
}
```
🔹 **Body (Form-Data):**  
| Key          | Value                  | Type  |
|-------------|----------------------|-------|
| `title`     | My First Task         | Text  |
| `description` | Test task description | Text  |
| `file`      | (Upload a PDF/DOC)     | File  |
| `image`     | (Upload a JPG/PNG)     | File  |

🔹 **Response:**
```json
{
    "id": 1,
    "title": "My First Task",
    "description": "This is a test task",
    "status": "pending",
    "file_path": "files/document.pdf",
    "image_path": "images/photo.jpg"
}
```

---

### **7️⃣ Update an Existing Task**
📌 **Endpoint:** `PUT /api/tasks/{id}`  
🔹 **Headers:**
```json
{
    "Accept": "application/json",
    "Authorization": "Bearer your_token_here"
}
```
🔹 **Body (JSON - raw):**
```json
{
    "title": "Updated Task",
    "description": "Updated description",
    "status": "completed"
}
```
🔹 **Response:**
```json
{
    "id": 1,
    "title": "Updated Task",
    "description": "Updated description",
    "status": "completed",
    "file_path": "files/document.pdf",
    "image_path": "images/photo.jpg"
}
```

---

### **8️⃣ Delete a Task**
📌 **Endpoint:** `DELETE /api/tasks/{id}`  
🔹 **Headers:**
```json
{
    "Accept": "application/json",
    "Authorization": "Bearer your_token_here"
}
```
🔹 **Response:**
```json
{
    "message": "Task deleted"
}
```

---

## **🖼️ File Upload & Access API**
### **9️⃣ Download an Uploaded File**
📌 **For Documents:** `GET /files/{filename}`  
📌 **For Images:** `GET /images/{filename}`

🔹 **Example:**
```bash
http://127.0.0.1:8000/files/document.pdf
http://127.0.0.1:8000/images/photo.jpg
```
✅ This allows your frontend to **fetch and display uploaded files**.

---

## **💻 React Frontend Integration (Axios)**
Your frontend developer can use **Axios** to integrate this API.

### **🔹 Example: Login & Store Token**
```javascript
import axios from 'axios';

const login = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      email: 'john@example.com',
      password: 'password123',
    });

    localStorage.setItem('token', response.data.token);
  } catch (error) {
    console.error(error);
  }
};
```

---

### **🔹 Example: Fetch All Tasks**
```javascript
const fetchTasks = async () => {
  try {
    const token = localStorage.getItem('token');
    const response = await axios.get('http://127.0.0.1:8000/api/tasks', {
      headers: { Authorization: `Bearer ${token}` }
    });
    console.log(response.data);
  } catch (error) {
    console.error(error);
  }
};
```

---

### **🔹 Example: Upload Task with File**
```javascript
const createTask = async (title, description, file, image) => {
  try {
    const token = localStorage.getItem('token');
    const formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);
    if (file) formData.append('file', file);
    if (image) formData.append('image', image);

    const response = await axios.post('http://127.0.0.1:8000/api/tasks', formData, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'multipart/form-data'
      }
    });

    console.log('Task Created:', response.data);
  } catch (error) {
    console.error(error);
  }
};
```

---

## **✅ Final Notes**
- **All protected routes require `Authorization: Bearer YOUR_ACCESS_TOKEN`.**
- **Use `multipart/form-data` for file uploads.**
- **Fetch and display images using `/images/{filename}`.**

🚀 **Now your React frontend can fully integrate with the Laravel 11 API!** 🚀  
Let me know if you need more help! 😊


for Frontend Development 

Refer: https://chatgpt.com/share/67bd7205-8498-8001-a028-c392fbdfaac2
