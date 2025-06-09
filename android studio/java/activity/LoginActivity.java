package com.app.kostpink.activity;


import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.os.StrictMode;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import com.app.kostpink.MainActivity;
import com.app.kostpink.MainActivityAdmin;
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.model.LoginResponse;
import com.app.kostpink.model.LoginUserResponse;

import java.util.ArrayList;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LoginActivity extends AppCompatActivity {
    private static final int MY_PERMISSION_REQUEST = 1;
    private static final int PERMISSION_REQUEST_CODE = 1;
    EditText txtusername, txtpassword;
    Button btnLogin;
    TextView tvregister;
    SharedPrefManager sharedPrefManager;
    private String[] apppermissions = new String[]{
            Manifest.permission.CAMERA,
            Manifest.permission.CALL_PHONE,
            Manifest.permission.ACCESS_FINE_LOCATION,
            Manifest.permission.ACCESS_COARSE_LOCATION,
            Manifest.permission.INTERNET,
            Manifest.permission.WRITE_EXTERNAL_STORAGE,
            Manifest.permission.READ_EXTERNAL_STORAGE,
            Manifest.permission.RECORD_AUDIO

    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        //hide actionbar
        getSupportActionBar().hide();

        //hide status bar
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);
        checkAndRequestPermission();

        sharedPrefManager = new SharedPrefManager(getApplicationContext());

        txtusername = (EditText) findViewById(R.id.txtusername);
        txtpassword = (EditText) findViewById(R.id.txtpassword);
        tvregister = (TextView) findViewById(R.id.tvregister);
        btnLogin = (Button) findViewById(R.id.btnLogin);

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

//                Intent i = new Intent(LoginActivity.this, MainActivity.class);
//                startActivity(i);
                userLogin();
            }
        });

        tvregister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(LoginActivity.this, RegisterActivity.class);
                startActivity(i);
            }
        });
    }

    private void userLogin() {
        String username = txtusername.getText().toString().trim();
        String password = txtpassword.getText().toString().trim();

        if (username.isEmpty()) {
            txtusername.requestFocus();
            txtusername.setError("Please enter your username");
            return;
        }

        if (password.isEmpty()) {
            txtpassword.requestFocus();
            txtpassword.setError("Please enter your password");
            return;
        }

        if (password.length() < 4) {
            txtpassword.requestFocus();
            txtpassword.setError("Password must be at least 4 characters long");
            return;
        }

        Call<LoginResponse> call = ApiClient.getInstance().getApi().login(username, password);
        call.enqueue(new Callback<LoginResponse>() {
            @Override
            public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                if (response.isSuccessful() && response.body() != null) {
                    LoginResponse loginResponse = response.body();

                    if (loginResponse.getStatus().equals("true")) {
                        sharedPrefManager.saveCustomer(loginResponse.getCustomer());
                        Intent intent = new Intent(LoginActivity.this, MainActivity.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                        startActivity(intent);
                        finish();
                    } else {
                        AdminLogin();
                        Toast.makeText(LoginActivity.this, loginResponse.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                } else {
//                    Toast.makeText(LoginActivity.this, "Login Gagal.", Toast.LENGTH_SHORT).show();
                    AdminLogin();
                }
            }

            @Override
            public void onFailure(Call<LoginResponse> call, Throwable t) {
                Toast.makeText(LoginActivity.this, "Error: " + t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }


    private void AdminLogin() {
        String username = txtusername.getText().toString().trim();
        String password = txtpassword.getText().toString().trim();

        Call<LoginUserResponse> call = ApiClient.getInstance().getApi().loginUser(username, password);
        call.enqueue(new Callback<LoginUserResponse>() {
            @Override
            public void onResponse(Call<LoginUserResponse> call, Response<LoginUserResponse> response) {
                if (response.isSuccessful() && response.body() != null) {
                    LoginUserResponse loginUserResponse = response.body();

                    if (loginUserResponse.getStatus().equals("true")) {
                        sharedPrefManager.saveUser(loginUserResponse.getUser());
                        Intent intent = new Intent(LoginActivity.this, MainActivityAdmin.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                        startActivity(intent);
                        finish();
                    } else {
                        Toast.makeText(LoginActivity.this, loginUserResponse.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                } else {
                    Toast.makeText(LoginActivity.this, "Admin login failed. Please try again.", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<LoginUserResponse> call, Throwable t) {
                Toast.makeText(LoginActivity.this, "Error: " + t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }


    private boolean checkAndRequestPermission() {
        StrictMode.VmPolicy.Builder builder = new StrictMode.VmPolicy.Builder();
        StrictMode.setVmPolicy(builder.build());
        java.util.List<String> listPermissionsNeeded = new ArrayList<>();
        for (String perm : apppermissions) {
            if (ContextCompat.checkSelfPermission(LoginActivity.this, perm) != PackageManager.PERMISSION_GRANTED) {
                listPermissionsNeeded.add(perm);
            }
        }

        if (!listPermissionsNeeded.isEmpty()) {
            ActivityCompat.requestPermissions(LoginActivity.this, listPermissionsNeeded.toArray(new String[listPermissionsNeeded.size()]),
                    PERMISSION_REQUEST_CODE);
            return false;
        }
        return true;
    }


}