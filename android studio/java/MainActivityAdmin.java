package com.app.kostpink;

import android.content.DialogInterface;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.MenuItem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import com.app.kostpink.fragment.AccountFragment;
import com.app.kostpink.fragment.ActivityFragment;
import com.app.kostpink.fragment.AdmAccountFragment;
import com.app.kostpink.fragment.AdmFeaturedFragment;
import com.app.kostpink.fragment.FeaturedFragment;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.navigation.NavigationBarView;

public class MainActivityAdmin extends AppCompatActivity {
    private static final int MY_PERMISSION_REQUEST = 1;
    SharedPrefManager sharedPrefManager;
    BottomNavigationView bottomNavigation;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.adm_activity_main);

        getSupportActionBar().hide();

//        //hide status bar
//        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
//                WindowManager.LayoutParams.FLAG_FULLSCREEN);

        sharedPrefManager = new SharedPrefManager(getApplicationContext());

        bottomNavigation = (BottomNavigationView) findViewById(R.id.bottomNavigationView);
        getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, new AdmFeaturedFragment()).commit();
        bottomNavigation.setOnItemSelectedListener(new NavigationBarView.OnItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {

                Fragment selectedFragment = null;
                if (item.getItemId() == R.id.home) {
                    selectedFragment = new AdmFeaturedFragment();
                } else {
                    selectedFragment = new AdmAccountFragment();
                }

                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, selectedFragment).commit();
                return true;
            }
        });


    }


    public void keluar() {
        new AlertDialog.Builder(this).setTitle("Menutup Aplikasi").setMessage("Terimakasih... Anda Telah Menggunakan Aplikasi Ini").setNeutralButton("Tutup", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dlg, int sumthin) {
                finish();
            }
        }).show();
    }

    public void keluarYN() {
        AlertDialog.Builder ad = new AlertDialog.Builder(MainActivityAdmin.this);
        ad.setTitle("Konfirmasi");
        ad.setMessage("Apakah benar ingin keluar?");

        ad.setPositiveButton("OK", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                finish();
            }
        });

        ad.setNegativeButton("No", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface arg0, int arg1) {
            }
        });

        ad.show();
    }

    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            keluarYN();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }
}