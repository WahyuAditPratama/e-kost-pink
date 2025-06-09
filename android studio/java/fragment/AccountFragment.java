package com.app.kostpink.fragment;

import android.Manifest;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.core.app.ActivityCompat;
import androidx.fragment.app.Fragment;

import com.app.kostpink.Config;
import com.app.kostpink.R;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.activity.AboutActivity;
import com.app.kostpink.activity.LoginActivity;
import com.app.kostpink.activity.ProfileActivity;
import com.app.kostpink.activity.UpdatePasswordActivity;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;

import java.io.IOException;
import java.util.List;
import java.util.Locale;


public class AccountFragment extends Fragment {

    SharedPrefManager sharedPrefManager;
    Button btnLogout;
    TextView tv_name, tv_email, tv_phone;
    ImageView imgavatar;
    String customer_id, name, email, avatar, phone;

    RelativeLayout btn_profile, btn_changePassword, btn_about;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_account, container, false);

        return view;
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        sharedPrefManager = new SharedPrefManager(getActivity());
        name = sharedPrefManager.getCustomer().getNama_customer();
        email = sharedPrefManager.getCustomer().getEmail();
        avatar = sharedPrefManager.getCustomer().getAvatar();
        phone = sharedPrefManager.getCustomer().getTelepon();
        customer_id = sharedPrefManager.getCustomer().getId_customer();

        tv_name = view.findViewById(R.id.tv_name);
        tv_name.setText(name);
        tv_email = view.findViewById(R.id.tv_email);
        tv_email.setText(email);
        tv_phone = view.findViewById(R.id.tv_phone);
        tv_phone.setText(phone);
        imgavatar = view.findViewById(R.id.img_avatar);

        Glide.with(this).load(Config.IMAGE_URL + "customer/" + avatar)
                .apply(new RequestOptions().override(480, 380)).into(imgavatar);



        btn_profile = view.findViewById(R.id.btn_profile);
        btn_profile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getContext(), ProfileActivity.class);
                startActivity(i);
            }
        });

        btn_changePassword = view.findViewById(R.id.btn_changePassword);
        btn_changePassword.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getContext(), UpdatePasswordActivity.class);
                startActivity(i);
            }
        });

        btn_about = view.findViewById(R.id.btn_about);
        btn_about.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getContext(), AboutActivity.class);
                startActivity(i);
            }
        });

//
        btnLogout = view.findViewById(R.id.btn_logout);
        btnLogout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                keluarYN();
            }
        });


    }



    public void keluarYN() {
        AlertDialog.Builder ad = new AlertDialog.Builder(getContext());
        ad.setTitle("Konfirmasi");
        ad.setMessage("Apakah benar ingin keluar?");

        ad.setPositiveButton("OK", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                sharedPrefManager.logout();
                Intent i = new Intent(getContext(), LoginActivity.class);
                getActivity().finish();
                startActivity(i);
            }
        });

        ad.setNegativeButton("No", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface arg0, int arg1) {
            }
        });

        ad.show();
    }

}