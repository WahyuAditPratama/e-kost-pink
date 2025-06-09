package com.app.kostpink.model;


import com.google.gson.annotations.SerializedName;

public class BookingResponse {

    String error;
    String message;

    @SerializedName("status")
    String status;

    public BookingResponse(String error, String message) {
        this.error = error;
        this.message = message;
    }

    public String getError() {
        return error;
    }

    public void setError(String error) {
        this.error = error;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}
