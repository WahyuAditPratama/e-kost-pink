package com.app.kostpink.activity;


import android.app.DatePickerDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.Config;
import com.app.kostpink.MainActivity;
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.model.UpdateProfileResponse;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;

import java.util.Calendar;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ProfileActivity extends AppCompatActivity {
    EditText txtnama, txtemail, txttelepon, txtalamat,  txttanggallahir, txtusername;
    TextView tv_nama, tv_email;
    ImageView imgavatar;
    String id_customer, nama_customer, email, avatar, telepon, username, alamat, tempat_lahir, tanggal_lahir;
    SharedPrefManager sharedPrefManager;
    Button btn_edit, btn_update_avatar;
    DatePickerDialog picker;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);


        //hide actionbar
        // getSupportActionBar().hide();

        sharedPrefManager = new SharedPrefManager(this);
        nama_customer = sharedPrefManager.getCustomer().getNama_customer();
        email = sharedPrefManager.getCustomer().getEmail();
        username = sharedPrefManager.getCustomer().getUsername();
        telepon = sharedPrefManager.getCustomer().getTelepon();
        alamat = sharedPrefManager.getCustomer().getAlamat();
        tempat_lahir = sharedPrefManager.getCustomer().getTempat_lahir();
        tanggal_lahir = sharedPrefManager.getCustomer().getTanggal_lahir();
        id_customer = sharedPrefManager.getCustomer().getId_customer();
        avatar = sharedPrefManager.getCustomer().getAvatar();


        //hide status bar

        txtnama = (EditText) findViewById(R.id.txtnama);
        txtemail = (EditText) findViewById(R.id.txtemail);
        txttelepon = (EditText) findViewById(R.id.txttelepon);
        txtusername = (EditText) findViewById(R.id.txtusername);
        txtalamat = (EditText) findViewById(R.id.txtalamat);
        txttanggallahir = (EditText) findViewById(R.id.txttanggallahir);
        tv_nama = findViewById(R.id.tvnama);
        tv_email = findViewById(R.id.tvemail);
        imgavatar = findViewById(R.id.imgavatar);

        Glide.with(this).load(Config.IMAGE_URL + "customer/" + avatar)
                .apply(new RequestOptions()).into(imgavatar);


        tv_nama.setText(nama_customer);
        tv_email.setText(email);
        txtnama.setText(nama_customer);
        txtemail.setText(email);
        txttelepon.setText(telepon);
        txtalamat.setText(alamat);
        txttanggallahir.setText(tanggal_lahir);
        txtusername.setText(username);

        txttanggallahir.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final Calendar cldr = Calendar.getInstance();
                int day = cldr.get(Calendar.DAY_OF_MONTH);
                int month = cldr.get(Calendar.MONTH) + 1;
                int year = cldr.get(Calendar.YEAR);
                picker = new DatePickerDialog(ProfileActivity.this, new DatePickerDialog.OnDateSetListener() {
                    @Override
                    public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                        String BUL = "Januari";
                        int b = (monthOfYear + 1);
                        if (b == 1) {
                            BUL = "Januari";
                        } else if (b == 2) {
                            BUL = "Februari";
                        } else if (b == 3) {
                            BUL = "Maret";
                        } else if (b == 4) {
                            BUL = "Aprril";
                        } else if (b == 5) {
                            BUL = "Mei";
                        } else if (b == 6) {
                            BUL = "Juni";
                        } else if (b == 7) {
                            BUL = "Juli";
                        } else if (b == 8) {
                            BUL = "Agustus";
                        } else if (b == 9) {
                            BUL = "September";
                        } else if (b == 10) {
                            BUL = "Oktober";
                        } else if (b == 11) {
                            BUL = "November";
                        } else if (b == 12) {
                            BUL = "Desember";
                        }
                        txttanggallahir.setText(dayOfMonth + " " + BUL + " " + year);
                    }
                }, year, month, day);
                picker.show();
            }
        });

        btn_edit = findViewById(R.id.btn_editProfile);
        btn_update_avatar = findViewById(R.id.btn_editavatar);
        btn_edit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Log.d("BUtton", "onClick: ");
                updateProfile();
            }
        });
        btn_update_avatar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(ProfileActivity.this, UpdateAvatar.class);
                finish();
                startActivity(i);
            }
        });

    }

    private void updateProfile() {

        String nama_customer = txtnama.getText().toString();
        String email = txtemail.getText().toString();
        String telepon = txttelepon.getText().toString();
        String alamat = txtalamat.getText().toString();
        String tanggal_lahir = txttanggallahir.getText().toString();
        String username = txtusername.getText().toString();

        Call<UpdateProfileResponse> call = ApiClient
                .getInstance()
                .getApi()
                .updateProfile(id_customer, nama_customer, email, telepon, alamat, tempat_lahir, tanggal_lahir, username);

        call.enqueue(new Callback<UpdateProfileResponse>() {
            @Override
            public void onResponse(Call<UpdateProfileResponse> call, Response<UpdateProfileResponse> response) {

                UpdateProfileResponse updateProfileResponse = response.body();
                if (response.isSuccessful()) {
                    sharedPrefManager.saveCustomer(updateProfileResponse.getCustomer());
                    Intent intent = new Intent(ProfileActivity.this, MainActivity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
                    finish();
                    Toast.makeText(ProfileActivity.this, updateProfileResponse.getMessage(), Toast.LENGTH_SHORT).show();

                } else {
                    Toast.makeText(ProfileActivity.this, updateProfileResponse.getMessage(), Toast.LENGTH_SHORT).show();
                }

            }

            @Override
            public void onFailure(Call<UpdateProfileResponse> call, Throwable t) {

                Toast.makeText(ProfileActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }

    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent i = new Intent(ProfileActivity.this, MainActivity.class);
            finish();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }
}