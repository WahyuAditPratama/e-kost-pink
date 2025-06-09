package com.app.kostpink.activity;


import android.content.Intent;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.MainActivity;
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.model.UpdatePassResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class UpdatePasswordActivity extends AppCompatActivity {
    EditText txt_oldpassword, txtpassword;
    SharedPrefManager sharedPrefManager;
    String customer_id,pass;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_password);


        //hide actionbar
        getSupportActionBar().hide();
        sharedPrefManager = new SharedPrefManager(this);
        customer_id = sharedPrefManager.getCustomer().getId_customer();
        pass = sharedPrefManager.getCustomer().getPassword();


        txt_oldpassword = (EditText) findViewById(R.id.txt_oldpassword);
        txtpassword = (EditText) findViewById(R.id.txtpassword);

        Button btnProses = (Button) findViewById(R.id.btn_proses);
        btnProses.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                UpdatePassword();
            }
        });

    }

    private void UpdatePassword() {

        String old_password = txt_oldpassword.getText().toString();
        String password = txtpassword.getText().toString();


        if (old_password.isEmpty()) {
            txt_oldpassword.requestFocus();
            txt_oldpassword.setError("Please enter your current password");
            return;
        }
        if (password.isEmpty()) {
            txtpassword.requestFocus();
            txtpassword.setError("Please enter your new password");
            return;
        }

        if (password.length() < 4) {
            txtpassword.requestFocus();
            txtpassword.setError("Password harus lebih dari 4");
            return;
        }


        if (!pass.equals(old_password)) {
            txt_oldpassword.requestFocus();
            txt_oldpassword.setError("Password lama tidak sesuai");
            return;
        }


        Call<UpdatePassResponse> call = ApiClient
                .getInstance()
                .getApi()
                .updatePassword(customer_id, password);

        call.enqueue(new Callback<UpdatePassResponse>() {
            @Override
            public void onResponse(Call<UpdatePassResponse> call, Response<UpdatePassResponse> response) {

                UpdatePassResponse updatePassResponse = response.body();
                if (response.isSuccessful()) {

                    sharedPrefManager.saveCustomer(updatePassResponse.getCustomer());
                    Intent intent = new Intent(UpdatePasswordActivity.this, MainActivity.class);
                    startActivity(intent);
                    finish();
                    Toast.makeText(UpdatePasswordActivity.this, updatePassResponse.getMessage(), Toast.LENGTH_SHORT).show();

                } else {
                    Toast.makeText(UpdatePasswordActivity.this, updatePassResponse.getMessage(), Toast.LENGTH_SHORT).show();
                }

            }

            @Override
            public void onFailure(Call<UpdatePassResponse> call, Throwable t) {

                Toast.makeText(UpdatePasswordActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }

    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent i = new Intent(UpdatePasswordActivity.this, LoginActivity.class);
            finish();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }
}