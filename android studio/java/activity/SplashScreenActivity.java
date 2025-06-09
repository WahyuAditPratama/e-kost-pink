package com.app.kostpink.activity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.WindowManager;

import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.MainActivity;
import com.app.kostpink.MainActivityAdmin;
import com.app.kostpink.R;
import com.app.kostpink.SharedPrefManager;

public class SplashScreenActivity extends AppCompatActivity {

    SharedPrefManager sharedPrefManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash_screen);
        //hide actionbar
        getSupportActionBar().hide();
        //hide status bar
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);
        sharedPrefManager = new SharedPrefManager(getApplicationContext());

        if (sharedPrefManager.isLoggedIn()) {
            if (sharedPrefManager.isCustomer()) {


                new Handler().postDelayed(new Runnable() {
                    public void run() {

                        Intent intent = new Intent(SplashScreenActivity.this, MainActivity.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                        finish();
                        startActivity(intent);
                    }
                }, 5000);
            }else{

                new Handler().postDelayed(new Runnable() {
                    public void run() {

                        Intent intent = new Intent(SplashScreenActivity.this, MainActivityAdmin.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                        finish();
                        startActivity(intent);
                    }
                }, 5000);
            }
        } else {
            new Handler().postDelayed(new Runnable() {
                public void run() {
                    Intent intent = new Intent();
                    intent.setClass(SplashScreenActivity.this, LoginActivity.class);
                    SplashScreenActivity.this.startActivity(intent);
                    SplashScreenActivity.this.finish();
                }
            }, 2000);
        }
    }

}