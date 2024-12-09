import axios from "axios";

const apiClient = axios.create({
  baseURL: "http://127.0.0.1:8000/api", // Set your base API URL here
  headers: {
    "Content-Type": "application/json",
  },
});

// General API request function
const apiRequest = async (method, url, data = null) => {
  try {
    const response = await apiClient({
      method,
      url,
      data, // Request payload for POST and PUT
    });
    return response.data;
  } catch (error) {
    console.error(`Error in ${method} request to ${url}:`, error);
    throw error;
  }
};

// Fetch data for a given endpoint
export const fetchData = (url) => apiRequest("GET", url);

// Create or add data for a given endpoint
export const addData = (url, data) => apiRequest("POST", url, data);

// Update data for a given endpoint
export const updateData = (url, data) => apiRequest("PUT", url, data);

// Delete data for a given endpoint
export const deleteData = (url) => apiRequest("DELETE", url);
