package com.app.kostpink.activity;


import android.content.Intent;
import android.os.Bundle;
import android.util.Patterns;
import android.view.KeyEvent;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.model.RegisterResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class RegisterActivity extends AppCompatActivity {
    EditText txtnama, txtemail, txttelepon, txtusername, txtpassword;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);


        //hide actionbar
        getSupportActionBar().hide();

        //hide status bar
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);
//
        txtnama = (EditText) findViewById(R.id.txtnama);
        txtemail = (EditText) findViewById(R.id.txtemail);
        txttelepon = (EditText) findViewById(R.id.txttelepon);
        txtusername = (EditText) findViewById(R.id.txtusername);
        txtpassword = (EditText) findViewById(R.id.txtpassword);

        Button btnRegister = (Button) findViewById(R.id.btnRegister);
        btnRegister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                registerUser();
            }
        });

    }

    private void registerUser() {

        String nama_customer = txtnama.getText().toString();
        String email = txtemail.getText().toString();
        String telepon = txttelepon.getText().toString();
        String username = txtusername.getText().toString();
        String password = txtpassword.getText().toString();


        if (nama_customer.isEmpty()) {
            txtnama.requestFocus();
            txtnama.setError("Please enter your nama_customer");
            return;
        }
        if (email.isEmpty()) {
            txtemail.requestFocus();
            txtemail.setError("Please enter your email");
            return;
        }
        if (!Patterns.EMAIL_ADDRESS.matcher(email).matches()) {
            txtemail.requestFocus();
            txtemail.setError("Please enter correct email");
            return;
        }
        if (password.isEmpty()) {
            txtpassword.requestFocus();
            txtpassword.setError("Please enter your password");
            return;
        }
        if (password.length() < 4) {
            txtpassword.requestFocus();
            txtpassword.setError("Please enter your password");
            return;
        }


        Call<RegisterResponse> call = ApiClient
                .getInstance()
                .getApi()
                .register(nama_customer, email, telepon, username, password);

        call.enqueue(new Callback<RegisterResponse>() {
            @Override
            public void onResponse(Call<RegisterResponse> call, Response<RegisterResponse> response) {

                RegisterResponse registerResponse = response.body();
                if (response.isSuccessful()) {

                    Intent intent = new Intent(RegisterActivity.this, LoginActivity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
                    finish();
                    Toast.makeText(RegisterActivity.this, registerResponse.getMessage(), Toast.LENGTH_SHORT).show();

                } else {
                    Toast.makeText(RegisterActivity.this, registerResponse.getMessage(), Toast.LENGTH_SHORT).show();
                }

            }

            @Override
            public void onFailure(Call<RegisterResponse> call, Throwable t) {

                Toast.makeText(RegisterActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }

    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent i = new Intent(RegisterActivity.this, LoginActivity.class);
            finish();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }
}