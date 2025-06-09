package com.app.kostpink.model;

import com.google.gson.annotations.SerializedName;

public class LoginUserResponse {
    @SerializedName("status")
    String status;

    @SerializedName("data")
    User user;
    String error;

    @SerializedName("message")
    String message;

    public LoginUserResponse(User user, String error, String status, String message) {
        this.user = user;
        this.error = error;
        this.message = message;
    }


    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
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
