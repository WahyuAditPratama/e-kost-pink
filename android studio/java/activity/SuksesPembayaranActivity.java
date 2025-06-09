package com.app.kostpink.activity;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.Config;
import com.app.kostpink.MainActivity;
import com.app.kostpink.R;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.databinding.ActivityDetailBookingBinding;

public class SuksesPembayaranActivity extends AppCompatActivity {

    String imageUrl = Config.IMAGE_URL;
    SharedPrefManager sharedPrefManager;


    Button btn_proses;


String visible;
    @RequiresApi(api = Build.VERSION_CODES.O)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sukses_pembayaran);



        getSupportActionBar().setTitle("Sukses Pembayaran");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        btn_proses=findViewById(R.id.btn_proses);

      btn_proses.setOnClickListener(v -> {
          Intent intent = new Intent(SuksesPembayaranActivity.this, MainActivity.class);
          intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
          startActivity(intent);
          finish();

        });

    }

}


